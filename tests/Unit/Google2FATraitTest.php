<?php

use Vendor\Package\Traits\Google2FAAuthenticatable;
use Tests\Models\AdminUser;

// it('can enable and disable 2FA for a user', function () {
//     // Arrange: Buat instansi AdminUser
//     $user = new AdminUser();
//     $user->google2fa_secret = 'dummy_secret';

//     // Act: Aktifkan 2FA
//     $user->enableGoogle2FA();

//     // Assert: Pastikan 2FA aktif
//     expect($user->google2fa_enabled)->toBeTrue();

//     // Act: Nonaktifkan 2FA
//     $user->disableGoogle2FA();

//     // Assert: Pastikan 2FA nonaktif
//     expect($user->google2fa_enabled)->toBeFalse();
// });

// it('can generate QR code URL', function () {
//     // Arrange: Buat instansi AdminUser
//     $user = new AdminUser();
//     $user->google2fa_secret = 'dummy_secret';

//     // Act: Dapatkan QR Code URL
//     $qrCodeUrl = $user->getQRCodeUrl();

//     // Assert: QR Code URL valid
//     expect($qrCodeUrl)->toBeString();
//     expect(str_contains($qrCodeUrl, 'google.com'))->toBeTrue();
// });
