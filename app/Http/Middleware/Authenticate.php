<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    // protected function redirectTo(Request $request): ?string
    // {
    //     return $request->expectsJson() ? null : route('login');
    // }

    protected function redirectTo(Request $request): ?string
{
    if ($request->expectsJson()) {
        return null;
    }

    // If the request is for admin area → redirect to admin login
    if ($request->is('admin') || $request->is('admin/*')) {
        return route('admin.login');
    }

    // Otherwise, fallback: if you have a normal user login route
    // return route('login');

    // Or if you don't have a normal user login at all, send them home
    return url('/');
}

}
