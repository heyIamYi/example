<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\System\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function loginIndex()
    {
        return view('admin.login');
    }

    public function index()
    {
        $header = '使用者';
        $datas = $this->adminService->getUsers();
        return view('admin.admin', compact('datas', 'header'));
    }

    public function show($id = null)
    {
        $header = '使用者資料';
        $groups = $this->adminService->getUserGroup();
        if ($id == null) {
            return view('admin.edit.admin', compact('header', 'groups'));
        } else {
            $data = $this->adminService->findUser($id);
            return view('admin.edit.admin', compact('data', 'header', 'groups'));
        }
    }

    public function create(Request $request, $id = null)
    {
        if ($id == null) {
            if ($request->checkPassword != $request->password) {
                return redirect()->back()->with('error', '確認使用者密碼與密碼不符！');
            }

            // 確認使用者是否存在
            if ($this->adminService->checkUser($request->name)) {
                return redirect()->back()->with('error', '使用者帳號已存在！');
            }

            $input = $request->only('name', 'email', 'group_id', 'username');
            $input['password'] = Hash::make($request->password);
            $data = Admin::create($input);
            return redirect()->route('admin.user');
        } else {
            $data = $this->adminService->findUser($id);
            $oldPassword = $request->input('oldPassword');
            $newPassword = $request->input('password');
            if ($newPassword != null) {
                if (Hash::check($oldPassword, $data->password)) {
                    $data->password = Hash::make($newPassword);
                    $data->save();
                } else {
                    // 如果舊密碼不正確，就返回錯誤訊息
                    return redirect()->back()->with('error', '舊密碼不正確！');
                }
            }

            $input = $request->only('name', 'email', 'group_id', 'username');
            $data->fill($input);
            $data->save();
            return redirect()->route('admin.user');
        }
    }

    public function destory($id)
    {
        Admin::find($id)->delete();
        return response()->json(['status' => 200, 'msg' => '刪除成功']);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');
        $credentials['is_show'] = 1;

        //驗證資料
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'password' => 'required|string',
            'verifycode' => 'required|captcha',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $errors->add('verifycode', '驗證碼錯誤');

            return redirect()->route('admin.login.show')
                ->withErrors($errors)
                ->withInput($request->except('password'));
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->username);
            return redirect()->route('admin.index');
        } else {
            $errors = [
                'name' => '帳號、密碼錯誤或帳號已被停用, 請聯繫管理員',
                'password' => '帳號、密碼錯誤或帳號已被停用, 請聯繫管理員',
            ];

            return redirect()->route('admin.login.show')->withErrors($errors)
                ->withInput($request->except('password'));
        }
    }

    public function logout(Request $request)
    {
        // 使用 Auth facade 來處理登出
        Auth::logout();

        // 清除 Session 中的用戶信息
        $request->session()->forget('user_id');
        $request->session()->forget('user_name');

        // 使其他的 Session 失效
        $request->session()->invalidate();

        // 重新生成 CSRF token
        $request->session()->regenerateToken();

        // 登出後重定向到登入頁面
        return redirect()->route('admin.login.show');
    }

}
