<?php

it('registers the service provider', function () {
    // Pastikan service provider terdaftar
    $this->assertInstanceOf(
        \Encore\GoogleAuthenticator\GoogleAuthenticatorServiceProvider::class,
        $this->app->getProvider(\Encore\GoogleAuthenticator\GoogleAuthenticatorServiceProvider::class)
    );
});

it('registers the 2FA middleware', function () {
    // Cek apakah middleware terdaftar
    $this->assertContains(
        \Encore\GoogleAuthenticator\Http\Middleware\Google2FAMiddleware::class,
        $this->app['router']->getMiddlewareGroups()['admin']
    );
});
