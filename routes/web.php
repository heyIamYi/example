<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\System\AdminController;

// 首頁
use App\Http\Controllers\Front\IndexController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/**
 * 管理員登入
 */
Route::prefix('WebAdmin')
    ->group(function () {
        Route::get('login', [AdminController::class, 'loginIndex'])->name('admin.login.show');
        Route::post('login', [AdminController::class, 'login'])->name(('admin.login.post'));
    });

    /**
     * 首頁
     */
    Route::get('/', [IndexController::class, 'index'])->name('front.index');
