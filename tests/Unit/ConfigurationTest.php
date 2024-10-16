<?php

it('uses the correct configuration values', function () {
    // Act: Ambil nilai konfigurasi
    $enabled = config('google2fa.enabled');
    $lifetime = config('google2fa.lifetime');

    // Assert: Cek apakah konfigurasi yang benar digunakan
    expect($enabled)->toBeTrue();
    expect($lifetime)->toBe(0); // Asumsi default value adalah 0
});
