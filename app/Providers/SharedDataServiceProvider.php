<?php

namespace App\Providers;

use App\Models\Menu;
use App\Repositories\MenuRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\MetaRepository;
class SharedDataServiceProvider extends ServiceProvider
{
    protected $defer = true; // 設置這個屬性為 true，以便僅在需要時進行實例化

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MenuRepository::class, function ($app) {
            return new MenuRepository(new Menu());
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('back.*', function ($view) {
            $menus = app(MenuRepository::class)->getOrderedMenusWithPerms();
            $view->with('lists', $menus);
        });

        // view()->composer('dstravel.template.*', function ($view) {
        //     $icons = app(Icon::class)->getSortData();
        //     $footer_files = app(FileFooter::class)->getSortData();
        //     $companyInfos = app(CompanyInfo::class)->getSortData();
        //     $tripGroups = app(TripGroup::class)->getGroups();
        //     $tripInformations = app(TripInformation::class)->getSortData();

        //     // 前端SEO預設值
        //     $defaultMeta = app(MetaRepository::class)->getCombinedData(1);

        //     $view->with([
        //         'icons' => $icons,
        //         'footer_files' => $footer_files,
        //         'companyInfos' => $companyInfos,
        //         'tripGroups' => $tripGroups,
        //         'tripInformations' => $tripInformations,
        //         // SEO預設值
        //         'metaKeywords' => $defaultMeta->meta_keywords,
        //         'metaDescription' => $defaultMeta->meta_description,
        //         'pageTitle' => $defaultMeta->page_title ?? env('WEB_NAME', '鼎陞旅行社'),
        //         'pageScript' => $defaultMeta->page_script,
        //     ]);
        // });

        // 加入搜尋的全域變數
        view()->composer('back.list.*', function ($view) {
            $view->with([
                'keyword' => request()->input('keyword', ''),
                'is_show' => request()->input('is_show', ''),
            ]);
        });
    }
}
