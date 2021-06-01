<?php

namespace Ofcold\Module\Setting;

use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Support\Facades\Route;
use Ofcold\Extension\Providers\ServiceProvider;
use Ofcold\Module\Setting\Actions\{
    CreateSettingItem,
    UpdateSettingItem
};

use Ofcold\Module\Setting\Contracts\{
    CreateSettingItemInterface,
    SettingCollectionInterface,
    UpdateSettingItemInterface
};

class SettingModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }

        $this->registerResources();

        // dump($this->app->make(SettingCollectionInterface::class));

        $this->commands([
            Console\CreatedDefaultSetting::class,
            Console\CacheStoreSetting::class,
        ]);
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        $this->publishes([
            SettingModule::modulePath('resources/lang') => resource_path('lang/vendor/ofcold-setting'),
        ], 'ofcold-setting-lang');
    }

    /**
     * Register the package resources such as routes, templates, etc.
     *
     * @return void
     */
    public function registerResources()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ofcold.setting');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'ofcold.setting');
        $this->loadJsonTranslationsFrom(resource_path('lang/vendor/ofcold.setting'));
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->registerRoutes();
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        // Route::group(SettingModule::routeConfiguration(), fn () => $this->loadRoutesFrom(SettingModule::modulePath('routes/api.php')));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->configurationIsNotCached()) {
            $this->app['config']->addNamespace(SettingModule::modulePath('config'), 'ofcold.setting');
        }

        $this->app->singleton(SettingCollectionInterface::class, SettingCollection::class);
        $this->app->singleton(CreateSettingItemInterface::class, CreateSettingItem::class);
        $this->app->singleton(UpdateSettingItemInterface::class, UpdateSettingItem::class);
        // $this->app->booted(fn () => $this->app->singleton(SettingCollectionInterface::class, SettingCollection::class));
    }
}
