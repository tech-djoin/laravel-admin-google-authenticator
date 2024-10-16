<?php

return [
    /*
     * Enable / disable Google2FA.
     */
    'enabled' => env('ADMIN_2FA_ENABLED', true),
    
    /*
     * Lifetime in minutes.
     */
    'lifetime' => env('ADMIN_2FA_LIFETIME', 0), // 0 = eternal
    
    /*
     * Renew lifetime at every new request.
     */
    'keep_alive' => env('ADMIN_2FA_KEEP_ALIVE', true),
    
    /*
     * Guard name
     */
    'guard' => '',
    
    /*
     * 2FA verified session var.
     */
    'session_var' => 'admin_2fa_verified',

    /*
     * One Time Password View.
     */
    'setting-view' => 'admin::google2fa.setting',

    /*
     * One Time Password Verify View.
     */
    'view' => 'admin::google2fa.verify',
    
    /*
     * One Time Password request input name.
     */
    'otp_input' => 'google2fa_one_time_password',
    
    /*
     * One Time Password Window.
     */
    'window' => 1,
    
    /*
     * User's table column for google2fa secret.
     */
    'otp_secret_column' => 'google2fa_secret',

    /*
     * Throw exceptions or just fire events?
     */
    'throw_exceptions' => env('ADMIN_2FAOTP_THROW_EXCEPTION', true),

    /*
     * Which image backend to use for generating QR codes?
     *
     * Supports imagemagick, svg and eps
     */
    'qrcode_image_backend' => \PragmaRX\Google2FALaravel\Support\Constants::QRCODE_IMAGE_BACKEND_SVG,

    /*
     * Error messages
     */
    'error_messages' => [
        'wrong_otp'       => "Kode yang dimasukan salah.",
        'cannot_be_empty' => 'Kode tidak boleh kosong.',
        'unknown'         => 'Terjadi kesalahan. Coba lagi nanti.',
    ],
];