<?php

namespace TechDjoin\LaravelAdminGoogleAuthenticator\Http\Middleware;

use Closure;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class Google2FAMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!config('google2fa.enabled')) {
            return $next($request);
        }

        $user = auth()->user();
        if (!$user || !$user->google2faIsEnabled()) {
            return $next($request);
        }

        $authenticator = app(Authenticator::class)->boot($request);
        if ($authenticator->isAuthenticated()) {
            return $next($request);
        }

        return $authenticator->makeRequestOneTimePasswordResponse();
    }
}