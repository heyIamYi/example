<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

class AdminHomePageController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
}
