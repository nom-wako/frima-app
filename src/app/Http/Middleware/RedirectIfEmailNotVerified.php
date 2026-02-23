<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class RedirectIfEmailNotVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (
            Auth::check() &&
            Auth::user() instanceof MustVerifyEmail &&
            !Auth::user()->hasVerifiedEmail()
        ) {
            if (!$request->is('email/verify*')) {
                return redirect()->route('verification.notice');
            }
        }
        return $next($request);
    }
}
