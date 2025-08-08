<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Priority 1: Check if user is logged in and has language preference
        if (Auth::check() && Auth::user()->is_language) {
            App::setLocale(Auth::user()->is_language);
        }
        // Priority 2: Check if language is set in session
        elseif (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        // Priority 3: Default to English
        else {
            App::setLocale('en');
        }

        return $next($request);
    }
}
