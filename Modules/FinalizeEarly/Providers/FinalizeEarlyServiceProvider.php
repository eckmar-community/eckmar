<?php

namespace Modules\FinalizeEarly\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\FinalizeEarly\Main\Info;
use Modules\FinalizeEarly\Main\Procedure;

class FinalizeEarlyServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->registerInfo();
        $this->registerProcedure();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('finalizeearly.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'finalizeearly'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/finalizeearly');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/finalizeearly';
        }, \Config::get('view.paths')), [$sourcePath]), 'finalizeearly');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/finalizeearly');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'finalizeearly');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'finalizeearly');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }
    public function registerInfo(){
        $this->app->bind('FinalizeEarlyModule\Info', function ($app) {
            return new Info();
        });
    }
    public function registerProcedure(){
        $this->app->bind('FinalizeEarlyModule\Procedure', function ($app) {
            return new Procedure();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
