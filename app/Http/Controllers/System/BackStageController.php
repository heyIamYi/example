<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Repositories\MenuRepository;
use App\Repositories\MetaRepository;
use App\Repositories\AdminGroupPermRepository;
use App\Services\System\BaseService as Service;
use App\Services\System\NotificationMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackStageController extends Controller
{
    protected $mailService;
    protected $service;
    protected $menuRepo = '';
    protected $adminGroupPermRepo = '';
    protected $meta;
    protected $repo;
    protected $model;

    public function __construct()
    {
        $this->mailService = app(NotificationMailService::class);
        $this->service = app(Service::class);
        $this->menuRepo = app(MenuRepository::class);
        $this->adminGroupPermRepo = app(AdminGroupPermRepository::class);
        $this->meta = app(MetaRepository::class);
    }

       /**
     * 初始化ViewData資料
     */

     protected function initializeViewData(Request $request, $id = null)
     {
         $path = $this->getPath($request);
         return $this->getViewData($path, $id);
     }

    /**
     * 透過path名稱, 取得通用資料
     */
    public function getViewData($path, $id = null)
    {
        $header = $this->menuRepo->where('alias', '=', $path)->first()->name;
        $pathId = $this->menuRepo->where('alias', '=', $path)->first()->id;
        $permCheck = null;

        if ($pathId !== null) {
            $permCheck = $this->adminGroupPermRepo
                ->where('group_id', '=', Auth::guard('admin')->user()->group->id)
                ->where('menu_id', '=', $pathId)
                ->first();
        }

        $formLink = '/WebAdmin/form/' . $path;
        $deleteLink = '/WebAdmin/form/delete/' . $path;

        // 如果有id, 則為修改頁面, 否則為新增頁面
        if ($id !== null) {
            $storeLink = '/WebAdmin/form/store/' . $path . '/' . $id;
        } else {
            $storeLink = '/WebAdmin/form/store/' . $path;
        }

        return compact('header', 'formLink', 'deleteLink', 'permCheck', 'storeLink');
    }

    /**
     * 修改後台狀態:
     * 取得Model名稱後, 前往對應Repository修改資料
     */
    public function state(Request $request)
    {
        $type = $request->type;
        $path = $request->path;
        $id = $request->id;
        $value = $request->value;
        try {
            $orginaleRepoName = $this->generateModelName($path);
            $repoName = $this->exceptionRepo($orginaleRepoName);
            $className = $repoName . 'Repository';
            $this->model = app('App\Repositories\\' . $className);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        switch ($type) {
            case 'sort':
                $this->model->sort($value, $id);
                return response()->json(['success' => '排序已更新']);
            case 'show':
                $this->model->isShow($value, $id);
                return response()->json(['success' => '顯示狀態已更新']);
            case 'hot':
                $this->model->isHot($value, $id);
                return response()->json(['success' => '熱門狀態已更新']);
            case 'new':
                $this->model->isNew($value, $id);
                return response()->json(['success' => '最新狀態已更新']);
            case 'index':
                $this->model->isIndex($value, $id);
                return response()->json(['success' => '顯示於首頁狀態已更新']);
        }

    }

    public function getPath(Request $request, $key = 2)
    {
        // 獲得當前的路由片段
        $segments = $request->segments();

        // 假設 URL 是 domain.com/admin/list/xxxx
        // 所以是 $segments[2]
        if (isset($segments[$key])) {
            $path = $segments[$key];
            return $path;
        }
        return null;
    }
}
