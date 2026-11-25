<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    private const MAX_ATTEMPTS = 5;      // wrong passwords allowed…
    private const DECAY_SECONDS = 300;   // …per 5 minutes, per email + IP

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email:rfc', 'max:150'],
            'password' => ['required', 'string', 'min:6', 'max:200'],
        ], [
            'email.required'    => 'Please enter your email address.',
            'email.email'       => 'Please enter a valid email address.',
            'password.required' => 'Please enter your password.',
            'password.min'      => 'Password must be at least 6 characters.',
        ]);

        $key = 'admin-login:' . Str::lower($credentials['email']) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($key);

            return back()
                ->withErrors(['email' => "Too many login attempts. Please try again in " . ceil($seconds / 60) . " minute(s)."])
                ->with('lockout_seconds', $seconds)
                ->onlyInput('email');
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            RateLimiter::clear($key);
            // New session id after login prevents session-fixation attacks.
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        RateLimiter::hit($key, self::DECAY_SECONDS);
        $left = self::MAX_ATTEMPTS - RateLimiter::attempts($key);

        Log::warning('Failed admin login', ['email' => $credentials['email'], 'ip' => $request->ip()]);

        return back()
            ->withErrors(['password' => 'Incorrect email or password.' . ($left > 0 && $left <= 2 ? " {$left} attempt(s) left." : '')])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'You have been logged out.');
    }
}
