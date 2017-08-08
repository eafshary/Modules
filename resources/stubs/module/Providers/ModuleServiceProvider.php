<?php

namespace DummyNamespace\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'DummySlug');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'DummySlug');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations', 'DummySlug');
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->registerConfig();
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        // $this->publishes([
        //     __DIR__.'/../Config/config.php' => config_path('test.php'),
        // ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'DummySlug' 
        );
    }
}
