<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 排除 HTML 標籤
        Validator::extend('strip_tags', function ($attribute, $value, $parameters, $validator) {
            $strippedValue = strip_tags($value);
            return $value === $strippedValue;
        });
    }
}
