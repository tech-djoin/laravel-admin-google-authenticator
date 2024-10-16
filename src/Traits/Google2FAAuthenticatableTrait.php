<?php

namespace TechDjoin\LaravelAdminGoogleAuthenticator\Traits;

use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

trait Google2FAAuthenticatableTrait
{
    /**
     * Get the Google2FA secret key.
     *
     * @return string
     */
    public function getGoogle2FASecretKey()
    {
        return $this->{config('google2fa.otp_secret_column')};
    }

    /**
     * Set the Google2FA secret key.
     *
     * @param string $value
     * @return void
     */
    public function setGoogle2FASecretKey($value)
    {
        $this->{config('google2fa.otp_secret_column')} = $value;
    }

    /**
     * Verify the Google2FA code.
     *
     * @param string ?$secret
     * @param string $code
     * @return bool
     */
    public function verifyGoogle2FA(string $code, string $secret = null)
    {
        $userSecret = $this->getGoogle2FASecretKey();
        if (empty($secret)) {
            $secret = $userSecret;
            if (empty($secret)) {
                return false;
            }
        }

        $google2fa = new Google2FA();
        
        return $google2fa->verifyKey($secret, $code, config('google2fa.window'));
    }

    /**
     * Generate a new secret key.
     *
     * @return string
     */
    public function generateGoogle2FASecret()
    {
        $google2fa = new Google2FA();
        return $google2fa->generateSecretKey();
    }

    /**
     * Get the QR code URL.
     *
     * @return string
     */
    public function getGoogle2FAQRCodeUrl(string $secret = null)
    {
        $google2fa = new Google2FA();
        $company = config('app.name');

        $inlineUrl = $google2fa->getQRCodeUrl(
            $company,
            $this->name,
            $secret
        );

        $temp_file = tempnam(sys_get_temp_dir(), 'qrcode');
        QrCode::format('png')->generate($inlineUrl, $temp_file.'.png');

        return base64_encode(file_get_contents($temp_file.'.png'));
    }

    /**
     * Determine if the user has enabled 2FA.
     *
     * @return bool
     */
    public function google2faIsEnabled()
    {
        return !empty($this->getGoogle2FASecretKey()) && config("google2fa.enabled", true);
    }
}