<?php

namespace Encore\GoogleAuthenticator\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Encore\GoogleAuthenticator\GoogleAuthenticatorServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

    }

    protected function getPackageProviders($app)
    {
        return [
            GoogleAuthenticatorServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Tambahkan middleware ke grup admin
        $app['router']->middlewareGroup('admin', [
            \Encore\GoogleAuthenticator\Http\Middleware\Google2FAMiddleware::class,
        ]);

        // Set up konfigurasi environment jika perlu
        $app['config']->set('google2fa.enabled', true);
    }

    // protected function defineDatabaseMigrations()
    // {
    //     $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    // }
}