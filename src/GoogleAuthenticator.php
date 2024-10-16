<?php

namespace Encore\GoogleAuthenticator;

use Encore\Admin\Extension;

class GoogleAuthenticator extends Extension
{
    public $name = 'google-authenticator';

    public $views = __DIR__.'/../resources/views';
    
    public $assets = __DIR__.'/../resources/assets';

    public $menu = [
        'title' => 'Google 2FA Settings',
        'path'  => '2fa/setting',
        'icon'  => 'fa-lock',
    ];
}