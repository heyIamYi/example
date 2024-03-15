<?php

namespace App\Services\System;

use App\Services\System\BaseService;
use Illuminate\Support\Facades\Auth;

class PageRenderService extends BaseService
{
    /**
     *  說明：處理後臺頁面的顯示邏輯
     *  1. 後台首頁請搜尋   indexPage
     *  2. 後台編輯頁請搜尋 formPage
     */

    public function indexPage($request = null, $alias)
    {

        if (isset($keyword) || isset($is_show)) {
            $keyword = $request->input('keyword');
            $is_show = $request->input('is_show');
            $selectValues = [];

            if ($alias == 'about' || $alias == 'contactmail' || $alias == 'contact') {
                $query = null;
            } else {
                $query = $this->{$alias . 'Repo'}->orderBy('sort');
                if ($keyword) {
                    $query->where('title', 'LIKE', "%$keyword%");
                }

                if ($is_show !== null) {
                    $query->where('is_show', $is_show);
                }
            }

            // 將搜尋結果加入session
            session()->forget('bk_keyword');
            session()->forget('bk_show');
            session()->forget('value1');
            session()->forget('value2');
            if (!empty($keyword)) {
                session(['bk_keyword' => $keyword]);
            }

            if (isset($is_show)) {
                session(['bk_show' => $is_show]);
            }

        }
        if (isset($query)) {
            $datas = $query->paginate(10);
        } else {
            $datas = null;
        }

        $aliasId = $this->menuRepo->where('alias', '=', $alias)->first()->id;
        $header = $this->menuRepo->where('alias', '=', $alias)->first()->name;
        if ($aliasId != null) {
            $permCheck = $this->adminGroupPermRepo
                ->where('group_id', '=', Auth::guard('admin')->user()->group->id)
                ->where('menu_id', '=', $aliasId)
                ->first();
        }

        switch ($alias) {
            case 'contact-mail':
                $datas = $this->contactMailRepo->all();
                return view('back.index.contactMail', compact('createLink', 'datas', 'editLink', 'permCheck', 'deleteLink', 'header'));
            case 'admin-group':
                $datas = $this->adminGroupRepo->all();
                return view('admin.user-group', compact('datas', 'createLink', 'deleteLink', 'editLink', 'permCheck', 'header'));
            case 'admin':
                $datas = $this->adminRepo->all();
                return view('admin.user', compact('datas', 'createLink', 'deleteLink', 'editLink', 'permCheck', 'header'));
            case 'admin-group-permission':
                $datas = $this->adminGroupPermRepo->all();
                $userGroups = $this->adminGroupRepo->all();
                return view('admin.group-permission', compact('datas', 'createLink', 'deleteLink', 'editLink', 'permCheck', 'userGroups', 'header'));
            case 'setting':
                $datas = $this->settingRepo->all();
                return view('admin.setting', compact('datas', 'createLink', 'deleteLink', 'editLink', 'permCheck', 'header'));
            case 'meta':
                $datas = $this->metaRepo->all();
                return view('admin.meta', compact('datas', 'createLink', 'deleteLink', 'editLink', 'permCheck', 'header'));
        }

    }
}
