<?php

namespace TechDjoin\LaravelAdminGoogleAuthenticator\Http\Controllers;

use Encore\Admin\Facades\Admin;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class GoogleAuthenticatorController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Show Google 2FA Settings page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSettings()
    {
        $user = auth()->user();
        $secret = $user->google2faIsEnabled() ? $user->getGoogle2FASecretKey() : $user->generateGoogle2FASecret();
        $qrCodeUrl = $user->getGoogle2FAQRCodeUrl($secret);

        return Admin::content(function ($content) use ($secret, $qrCodeUrl, $user) {
            $content->header('Pengaturan Two-Factor Authentication');
            $content->description(' ');

            $content->body(view(config("google2fa.setting-view"), [
                config('google2fa.otp_input') => $secret,
                "secret" => $secret,
                'qrCodeUrl' => $qrCodeUrl,
                'isEnabled' => $user->google2faIsEnabled(),
            ]));
        });
    }

    /**
     * Enable 2FA for user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function enable(Request $request)
    {
        $this->validate($request, [
            config('google2fa.otp_input') => 'required|string|digits:6',
            config('google2fa.otp_secret_column') => 'required|string',
        ]);

        $user = auth()->user();
        if ($user->verifyGoogle2FA($request->{config('google2fa.otp_input')}, $request->{config('google2fa.otp_secret_column')})) {
            $user->setGoogle2FASecretKey($request->{config('google2fa.otp_secret_column')});
            $user->save();
            
            admin_toastr('2FA has been enabled successfully', 'success');
            return response()->json(['message' => 'success']);
        }

        return response()->json(['message' => config("google2fa.error_messages.wrong_otp")], 422);
    }

    /**
     * Disable 2FA for user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function disable(Request $request)
    {
        $this->validate($request, [
            config('google2fa.otp_input') => 'required|string|digits:6',
        ]);

        $user = auth()->user();
        if ($user->verifyGoogle2FA($request->{config('google2fa.otp_input')})) {
            $user->setGoogle2FASecretKey(null);
            $user->save();
            
            admin_toastr('2FA has been disabled successfully', 'success');
            return response()->json(['message' => 'success']);
        }

        return response()->json(['message' => config("google2fa.error_messages.wrong_otp")], 422);
    }

    /**
     * Show 2FA verification page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showVerification()
    {
        if (!auth()->user()->google2faIsEnabled()) {
            return redirect()->route('admin.home');
        }

        return view('google2fa::verify');
    }

    /**
     * Verify 2FA code
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify()
    {
        try {
            // kosong karena sudah di validasi oleh middleware Google2FAMiddleware dari vendor
            return response()->json([
                'status'    => 'success',
                'message'   => config("google2fa.error_messages.wrong_otp")
            ]);
        } catch (\Throwable $th) {
            \Log::error("2FA Verify : ".$th->getMessage()." ".$th->getFile()." ".$th->getLine());
            return response()->json([
                'status'    => 'fail',
                'message'   => config("google2fa.error_messages.unknown"),
                'error'     => $th->getMessage()
            ]);
        }
    }
}