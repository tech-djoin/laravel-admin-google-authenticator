<?php

namespace Tests\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Encore\GoogleAuthenticator\Traits\Google2FAAuthenticatableTrait;

class AdminUser extends Administrator
{
    use HasFactory, Google2FAAuthenticatableTrait;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google2fa_secret'
    ];
}