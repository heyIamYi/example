<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
class MenuRepository extends BaseRepository
{

    public function __construct(Menu $model)
    {
        parent::__construct($model);
    }
    public function getOrderedMenusWithPerms()
    {
        if (Auth::guard('admin')->user()->group->id === 1) {
            return $this->with('groupPerms')->orderBy('sort')->get();
        } else {
            // 排除 '系統管理' 這個menu
            return $this->with('groupPerms')->where('name', '!=', '系統管理')->orderBy('sort')->get();
        }
    }

}
