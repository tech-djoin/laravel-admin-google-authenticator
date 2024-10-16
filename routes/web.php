<?php

use TechDjoin\LaravelAdminGoogleAuthenticator\Http\Controllers\GoogleAuthenticatorController;

Route::get('2fa/setting', [GoogleAuthenticatorController::class, 'showSettings'])
    ->name('admin.2fa.settings');
Route::post('2fa/enable', [GoogleAuthenticatorController::class, 'enable'])
    ->name('admin.2fa.enable');
Route::post('2fa/disable', [GoogleAuthenticatorController::class, 'disable'])
    ->name('admin.2fa.disable');
Route::get('2fa/verify', [GoogleAuthenticatorController::class, 'showVerification'])
    ->name('admin.2fa.verify');
Route::post('2fa/verify', [GoogleAuthenticatorController::class, 'verify'])
    ->name('admin.2fa.verify.post');