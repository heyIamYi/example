<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\AdminGroupPerm;
use App\Services\System\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminGroupPermController extends Controller
{
    protected $service;

    public function __construct(
        AdminService $service,
    ) {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        // 如果群組不是1, 無法進入此頁面
        if (Auth::guard('admin')->user()->group->id !== 1) {
            return redirect()->route('admin.index');
        }
        $header = '權限管理';
        if (Auth::guard('admin')->user()->group->id === 1 && $request->has('g_id')) {
            $group_id = $request->input('g_id');
        } else {
            $group_id = Auth::guard('admin')->user()->group->id;
        }

        $datas = $this->service->getUserPermWithNoParent($group_id);
        $allDatas = $this->service->getUserPerm($group_id);
        $userGroups = $this->service->getUserGroup();

        // 取得Menu, 然後透過group_id取得該group的權限
        $allMenu = $this->service->getMenuWithGroupId($group_id);
        $menusByParent = $allMenu->groupBy('parent_id');
        return view('admin.permission', compact('datas', 'header', 'userGroups', 'group_id', 'allDatas', 'menusByParent'));
    }

    public function store($column, $id, $value)
    {
        if ($column == 'hide_sub') {
            return $this->editColumnValue($column, $id, $value);
        }

        $data = $this->service->findUserPerm($id);
        $data->$column = $value;
        $data->save();
        return json_encode(['status' => 200]);
    }

    private function editColumnValue($column, $id, $value)
    {
        $data = AdminGroupPerm::find($id);
        $data->$column = $value;
        $data->save();
        return json_encode(['status' => 200]);
    }
}
