<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Meta;
use App\Services\System\AdminService;
use Illuminate\Http\Request;

class MetaController extends Controller
{
    protected $service;
    public function __construct(
        AdminService $service
    ) {
        $this->service = $service;
    }

    public function index()
    {
        $header = '關鍵字管理';
        $datas = $this->service->getMeta();
        return view('admin.meta', compact('datas', 'header', ));
    }

    public function show($id)
    {
        $header = '關鍵字管理';
        $data = Meta::find($id);

        return view('admin.edit.meta', compact('data', 'header', ));
    }

    public function store(Request $request, $id)
    {
        $data = Meta::find($id);
        $input = $request->only('page_title', 'meta_keywords', 'meta_description');
        $data->fill($input);
        $data->save();
        return redirect()->route('admin.meta')->with('message', '更新成功');
    }
}
