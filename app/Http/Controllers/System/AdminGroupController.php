<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\AdminGroup;
use App\Models\AdminGroupPerm;
use App\Services\System\AdminService;
use Illuminate\Http\Request;

class AdminGroupController extends Controller
{
    protected $service;

    public function __construct(
        AdminService $service
    ) {
        $this->service = $service;
    }

    public function index()
    {
        $header = '群組管理';
        $datas = $this->service->getUserGroup();
        return view('admin.admin_group', compact('datas', 'header', ));
    }

    public function show($id)
    {
        $header = '群組管理';
        $data = AdminGroup::find($id);

        return view('admin.edit.group', compact('data', 'header', ));
    }

    public function create(Request $request)
    {
        $input = $request->only('name');
        // 如果有重複名稱返回錯誤
        if (AdminGroup::where('name', $input['name'])->first()) {
            return redirect()->back()->withErrors(['name' => '群組名稱重複']);
        }

        $group = AdminGroup::create($input);
        $menus = Menu::all();
        foreach ($menus as $menu) {
            $sTag = ($menu->alias == null) ? 1 : 1;
            $aTag = ($menu->alias == null) ? null : 1;
            $eTag = ($menu->alias == null) ? null : 1;
            $dTag = ($menu->alias == null) ? null : 1;

            AdminGroupPerm::create([
                'group_id' => $group->id,
                'menu_id' => $menu->id,
                's_tag' => $sTag,
                'a_tag' => $aTag,
                'e_tag' => $eTag,
                'd_tag' => $dTag,
            ]);
        }

        return redirect()->back();
    }

    // public function store(Request $request, $id)
    // {
    //     $data = AdminGroup::find($id);
    //     $input = $request->only('name');
    //     $data->fill($input);
    //     $data->save();

    //     return redirect();
    // }

    public function destory($id)
    {
        $data = AdminGroup::find($id);
        AdminGroupPerm::where('group_id',$data->id)->delete();
        $data->delete();
    }
}
