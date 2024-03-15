<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\System\AdminService;

class SettingController extends Controller
{
    protected $service;
    public function __construct(
        AdminService     $service
        ){
        $this->service         = $service;
    }

    public function index()
    {
        $header = '參數設定';
        $data = $this->service->getSettings();
        return view('admin.setting', compact('data', 'header'));
    }

    public function store(Request $request)
    {
        $input = $request->only('value');
        $data = $this->service->getSettings();
        $data->fill($input);
        $data->save();
        return redirect(route('back.setting'));
    }
}
