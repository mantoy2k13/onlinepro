<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('layouts.user.frame', function ($view) {
            $view->with('languages', \LocaleHelper::getEnableLocales());
        });
        \View::composer('layouts.teacher.header', function ($view) {
            $view->with('languages', \LocaleHelper::getEnableLocales());
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
