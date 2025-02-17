<?php

it('registers the service provider', function () {
    // Pastikan service provider terdaftar
    $this->assertInstanceOf(
        \TechDjoin\LaravelAdminGoogleAuthenticator\GoogleAuthenticatorServiceProvider::class,
        $this->app->getProvider(\TechDjoin\LaravelAdminGoogleAuthenticator\GoogleAuthenticatorServiceProvider::class)
    );
});

it('registers the 2FA middleware', function () {
    // Cek apakah middleware terdaftar
    $this->assertContains(
        \TechDjoin\LaravelAdminGoogleAuthenticator\Http\Middleware\Google2FAMiddleware::class,
        $this->app['router']->getMiddlewareGroups()['admin']
    );
});
