<?php
use App\Http\Controllers\System\AdminController;
use App\Http\Controllers\System\AdminGroupController;
use App\Http\Controllers\System\AdminGroupPermController;
use App\Http\Controllers\System\BackStageController;
use App\Http\Controllers\System\MetaController;
use App\Http\Controllers\System\SettingController;
use App\Http\Controllers\WebAdmin\AdminContactController;
use App\Http\Controllers\WebAdmin\AdminContactMailController;
use App\Http\Controllers\System\AdminHomePageController;
use Illuminate\Support\Facades\Route;


/**
 * 後台頁面
 */
Route::prefix('WebAdmin')
    ->middleware(['admin'])
    ->group(function () {
        Route::get('/', [AdminHomePageController::class, 'index'])->name('admin.index');

        // 編輯器上傳圖片
        Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'admin']], function () {
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });
        // 後台系統管理頁面

        // 信件
        Route::get('/list/contact', [AdminContactController::class, 'list'])->name('list.contact');
        Route::get('/form/contact/{id?}', [AdminContactController::class, 'form'])->name('form.contact');
        Route::post('/form/store/contact/{id?}', [AdminContactController::class, 'store']);
        Route::post('/form/delete/contact/{id}', [AdminContactController::class, 'destroy']);

        // 聯絡信箱
        Route::get('/list/contact_mail', [AdminContactMailController::class, 'list']);
        Route::get('/form/contact_mail/{id?}', [AdminContactMailController::class, 'form'])->name('form.contact_mail');
        Route::post('/form/store/contact_mail/{id?}', [AdminContactMailController::class, 'store']);
        Route::post('/form/delete/contact_mail/{id}', [AdminContactMailController::class, 'destroy']);

        // 使用者群組
        Route::get('/list/admin_group', [AdminGroupController::class, 'index'])->name('admin.group.lst');
        Route::post('/c/admin_group', [AdminGroupController::class, 'create'])->name('admin.group.create');
        Route::post('/admin_group/{id}', [AdminGroupController::class, 'store']);
        Route::post('/d/admin_group/{id}', [AdminGroupController::class, 'destory']);

        // 使用者
        Route::get('/list/admin', [AdminController::class, 'index'])->name('admin.user');
        Route::get('/form/admin/{id?}', [AdminController::class, 'show'])->name('admin.edit.form');
        Route::post('/c/admin/{id?}', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/d/admin/{id}', [AdminController::class, 'destory'])->name('admin.destory');

        // google關鍵字
        Route::get('/list/setting', [SettingController::class, 'index'])->name('admin.setting');
        Route::post('/setting', [SettingController::class, 'store']);

        // 頁面seo
        Route::get('/list/meta', [MetaController::class, 'index'])->name('admin.meta');
        Route::get('/form/meta/{id}', [MetaController::class, 'show'])->name('admin.meta.show');
        Route::post('/meta/{id}', [MetaController::class, 'store'])->name('admin.meta.store');

        // 權限
        Route::get('/list/admin_group_permission/', [AdminGroupPermController::class, 'index'])->name('admin.perm');
        Route::get('/perm/{column}/{id}/{value}', [AdminGroupPermController::class, 'store']);

        // 後台狀態更改(show, new, hot, sort)
        Route::post('/modify', [BackStageController::class, 'state']);

        // 後台刪除
        Route::post('/delete/{path}/{id}', [BackStageController::class, 'deleteData']);

        // 登出
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    });
