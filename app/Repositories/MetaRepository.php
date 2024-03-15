<?php

namespace App\Repositories;

use App\Models\Meta;
use App\Repositories\BaseRepository;

class MetaRepository extends BaseRepository
{

    public function __construct(Meta $model)
    {
        parent::__construct($model);
    }

    /**
     * 取得預設資料並結合指定的頁面數據
     */
    public function getCombinedData($pageId, $defaultId = 1)
    {
        $pageData = $this->model->where('id', $pageId)->firstOrFail();
        $defaultData = $this->model->where('id', $defaultId)->firstOrFail();

        foreach ($pageData->toArray() as $key => $value) {
            if (is_null($value) && isset($defaultData->$key)) {
                $pageData->$key = $defaultData->$key;
            }
        }
        return $pageData;
    }

    /**
     * 整合頁面與預設的 SEO 資料
     */
    public function getMergedMeta($currentMeta, $pageId = 1)
    {
        $pageMetaArray = $this->getCombinedData($pageId);
        $metaArray = array('meta_keywords', 'meta_description', 'page_title', 'page_script');

        // 合併, 如果頁面沒有設定, 就用預設的
        return (object) collect($metaArray)->mapWithKeys(function ($key) use ($currentMeta, $pageMetaArray) {
            return [$key => $currentMeta->$key ?? $pageMetaArray->$key ?? null];
        })->toArray();
    }

}
