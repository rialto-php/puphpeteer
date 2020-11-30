<?php

namespace Nesk\Puphpeteer;


use Illuminate\Support\ServiceProvider;

class PuphpeteerServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '\PuphpeteerServiceProvider.php' =>  base_path('PuppeteerConnectionDelegate.js')
        ]);
    }
}
