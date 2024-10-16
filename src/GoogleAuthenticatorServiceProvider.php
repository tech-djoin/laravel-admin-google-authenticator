<?php

namespace Encore\GoogleAuthenticator;

use Encore\GoogleAuthenticator\Http\Middleware\Google2FAMiddleware;
use Illuminate\Support\ServiceProvider;

class GoogleAuthenticatorServiceProvider extends ServiceProvider
{
    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'admin.google-2fa' => Google2FAMiddleware::class
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'admin' => [
            'admin.google-2fa'
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function boot(GoogleAuthenticator $extension)
    {
        if (!GoogleAuthenticator::boot()) {
            return ;
        }

        $this->publishes([
            __DIR__.'/../config' => config_path(),
        ], 'config');

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'admin');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/laravel-admin-ext/google-authenticator')],
                'assets'
            );
        }

        $this->app->booted(function () {
            GoogleAuthenticator::routes(__DIR__.'/../routes/web.php');
        });
    }

    public function register()
    {
        $this->registerRouteMiddleware();
        $this->mergeConfigFrom(
            __DIR__.'/../config/google2fa.php', 'google2fa'
        );

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }

        foreach ($this->middlewareGroups as $key => $middleware) {
            foreach ($middleware as $middlewareKey) {
                app('router')->pushMiddlewareToGroup($key, $middlewareKey);
            }
        }
    }
}