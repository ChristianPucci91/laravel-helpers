<?php

namespace Pucci\LaravelHelpers;

use Illuminate\Support\ServiceProvider;

class LaravelHelpersServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Registriamo FileSaver come singleton
        $this->app->singleton(FileSaver::class, function ($app) {
            return new FileSaver();
        });

        // Facade
        $this->app->alias(FileSaver::class, 'filesaver');
    }

    public function boot()
    {
        //
    }
}
