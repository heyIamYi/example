<?php

namespace App\Services\System;

use App\Services\System\BaseService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CollectionProcessorService extends BaseService
{
    /**
     * 此Service用於處理Collection的資料
     */

    /**
     * 對項目進行分頁
     *
     * @param Collection $items 要分頁的項目
     * @param int $perPage 每頁的項目數量
     * @param int|null $page 當前頁碼
     * @param array $options 分頁的其他選項
     * @return LengthAwarePaginator 分頁後的項目
     */
    public function paginateItems($items, $perPage = 15, $page = null, $options = [])
    {
        // 取得當前頁數。如果未提供，則自動從請求中解析。
        $currentPage = $page ?: LengthAwarePaginator::resolveCurrentPage();

        // 使用提供的$perPage和$currentPage計算當前頁的項目
        $currentPageItems = $items->forPage($currentPage, $perPage)->values();

        // 創建一個LengthAwarePaginator實例。這是Laravel的分頁器，能夠提供分頁功能。
        $paginator = new LengthAwarePaginator(
            $currentPageItems, // 當前頁的項目
            $items->count(), // 總項目數量
            $perPage, // 每頁的項目數量
            $currentPage, // 當前頁碼
            $options // 其他選項
        );

        // 返回分頁器實例
        return $paginator;
    }
}
