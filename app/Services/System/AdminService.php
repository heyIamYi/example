<?php

namespace App\Services\System;

use App\Repositories\MenuRepository;
use App\Repositories\MetaRepository;
use App\Repositories\SettingRepository;
use App\Repositories\AdminGroupRepository;
use App\Repositories\AdminGroupPermRepository;
use App\Repositories\AdminRepository;
use App\Services\System\BaseService;

class AdminService extends BaseService
{
    protected $metaRepo;
    protected $settingRepo;
    protected $adminGroupRepo;
    protected $adminRepo;
    protected $menuRepo;
    protected $adminGroupPermRepo;

    public function __construct(
        MenuRepository $menuRepo,
        MetaRepository $metaRepo,
        SettingRepository $settingRepo,
        AdminGroupRepository $adminGroupRepo,
        AdminRepository $adminRepo,
        AdminGroupPermRepository $adminGroupPermRepo
    ) {
        $this->metaRepo = $metaRepo;
        $this->settingRepo = $settingRepo;
        $this->menuRepo = $menuRepo;
        $this->adminGroupRepo = $adminGroupRepo;
        $this->adminRepo = $adminRepo;
        $this->adminGroupPermRepo = $adminGroupPermRepo;
    }

    public function getMenus()
    {
        return $this->menuRepo->with('perms')->orderBy('sort')->get();
    }
    public function getMenuWithGroupId($group_id)
    {
        $datas = $this->adminGroupPermRepo
            ->with(['menu', 'group'])
            ->leftJoin('menus', 'admin_group_perms.menu_id', '=', 'menus.id')
            ->whereHas('menu', function ($query) {
                $query->where('hide_sub', 1);
            })
            ->whereHas('group', function ($query) use ($group_id) {
                $query->where('id', $group_id);
            })
            ->orderBy('menus.sort')
            ->select('admin_group_perms.*') // 選取 group_perms 表的所有欄位，避免與letfJoin的表重複
            ->get()
            ->map(function ($datas) {
                // 重新透過menu_id來排序
                $datas->original_id = $datas->id;
                $datas->id = $datas->menu_id;
                // 其他資料
                $datas->name = $datas->menu->name;
                $datas->parent_id = $datas->menu->parent_id;
                $datas->hide_sub = $datas->menu->hide_sub;
                return $datas;
            });
        return $datas;
    }
    public function getUsers()
    {
        return $this->adminRepo->all();
    }

    public function findUser($id)
    {
        return $this->adminRepo->find($id);
    }

    public function getSettings()
    {
        return $this->settingRepo->first();
    }

    public function getUserGroup()
    {
        return $this->adminGroupRepo->all();
    }

    public function getUserPermWithNoParent($group_id)
    {
        $datas = $this->adminGroupPermRepo
            ->with(['menu', 'group'])
            ->whereHas('menu', function ($query) {
                $query->where('hide_sub', 1)
                    ->where('parent_id', '!=', '0')
                // 自關聯表
                    ->whereHas('parent', function ($parentQeury) {
                        $parentQeury->where('hide_sub', '!=', 0);
                    });
            })
            ->whereHas('group', function ($query) use ($group_id) {
                $query->where('id', $group_id);
            })
            ->get()
            ->map(function ($data) {
                $data->hide_sub = $data->menu->hide_sub;
                return $data;
            });
        return $datas;
    }

    public function getUserPerm($group_id)
    {
        $datas = $this->adminGroupPermRepo
            ->with(['menu', 'group'])
            ->whereHas('menu', function ($query) {
                $query->where('hide_sub', 1);
            })
            ->whereHas('group', function ($query) use ($group_id) {
                $query->where('id', $group_id);
            })
            ->get()
            ->map(function ($data) {
                $data->title = $data->menu->name;
                return $data;
            });
        return $datas;
    }

    public function findUserPerm($id)
    {
        return $this->adminGroupPermRepo->find($id);
    }

    public function getMeta()
    {
        return $this->metaRepo->all();
    }

    /**
     * 檢查使用者是否已存在
     */
    public function checkUser($userNmae)
    {
        $user = $this->adminRepo->where('name', $userNmae)->first();
        if ($user) {
            return true;
        } else {
            return false;
        }
    }
}
