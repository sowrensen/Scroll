<?php


namespace Sowren\Scroll;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Sowren\Scroll\Facades\Scroll;

class ScrollBaseServiceProvider extends ServiceProvider
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
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            Console\Commands\ProcessCommand::class,
        ]);
    }

    /**
     * Register all package resources.
     *
     * @return void
     */
    private function registerResources()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'scroll');
        $this->registerFacades();
        $this->registerRoutes();
        $this->registerFields();
    }

    /**
     * Register package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing()
    {
        $this->publishes([
            __DIR__.'/../config/scroll.php' => config_path('scroll.php'),
        ], 'scroll-config');

        $this->publishes([
            __DIR__.'/Console/stubs/ScrollServiceProvider.stub' => app_path('Providers/ScrollServiceProvider.php'),
        ], 'scroll-provider');
    }

    /**
     * Register package routes.
     *
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::group($this->routeConfigurations(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    /**
     * Get route group configurations.
     *
     * @return array
     */
    private function routeConfigurations()
    {
        return [
            'prefix' => Scroll::prefix(),
            'namespace' => 'Sowren\Scroll\Http\Controllers',
        ];
    }

    /**
     * Register any bindings to the app.
     *
     * @return void
     */
    protected function registerFacades()
    {
        $this->app->singleton('Scroll', function ($app) {
            return new \Sowren\Scroll\Scroll();
        });
    }

    /**
     * Register default fields to the app.
     *
     * @return void
     */
    private function registerFields()
    {
        Scroll::fields([
            Fields\Body::class,
            Fields\Date::class,
            Fields\Description::class,
            Fields\Extra::class,
            Fields\Title::class,
        ]);
    }
}
