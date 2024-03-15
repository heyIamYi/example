<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LoggingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        app('events')->listen('logger.formatter.created', function ($logger, $driver) {
            foreach ($logger->getHandlers() as $handler) {
                $handler->setFormatter(new LineFormatter("[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n", 'Y-m-d H:i:s'));
            }
        });
    }
}
