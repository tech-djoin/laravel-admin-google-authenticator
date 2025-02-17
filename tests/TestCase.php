<?php

namespace TechDjoin\LaravelAdminGoogleAuthenticator\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use TechDjoin\LaravelAdminGoogleAuthenticator\GoogleAuthenticatorServiceProvider;

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
            \TechDjoin\LaravelAdminGoogleAuthenticator\Http\Middleware\Google2FAMiddleware::class,
        ]);

        // Set up konfigurasi environment jika perlu
        $app['config']->set('google2fa.enabled', true);
    }

    // protected function defineDatabaseMigrations()
    // {
    //     $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    // }
}