<?php

namespace Magdicom\NovaVisiblePassword;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-visible-password', __DIR__.'/../dist/js/field.js');
            Nova::style('nova-visible-password', __DIR__.'/../dist/css/field.css');
        });

        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'visiblePassword');

        $this->publishes([
            __DIR__ . '/../lang/' => $this->app->langPath('vendor/visiblePassword'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
