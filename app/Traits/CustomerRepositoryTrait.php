<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;

trait CustomerRepositoryTrait
{
    /**
     *  說明：前台頁面取資料使用
     */

    /**
     * 按照排序、是否顯示取得資料
     */
    public function getSortData($is_show = 1, $sort = 'asc')
    {
        if ($is_show == null) {
            return $this->model->orderBy('sort', $sort)->get();
        }
        return $this->model->where('is_show', $is_show)->orderBy('sort', $sort)->get();
    }

    /**
     *  加入判斷是否顯示於首頁的條件
     */
    public function getIndexData($is_show = 1, $sort = 'asc')
    {
        $query = $this->model->orderBy('sort', $sort);
        // 若$is_show不為null，添加到查詢中
        if (!is_null($is_show)) {
            $query->where('is_show', $is_show);
        }
        // 若存在is_index字段，取得值為1, 添加到查詢中
        if (Schema::hasColumn($this->model->getTable(), 'is_index')) {
            $query->where('is_index', 1);
        }
        return $query->get();
    }
}
