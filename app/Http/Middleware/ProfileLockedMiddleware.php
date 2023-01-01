<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Closure;

class ProfileLockedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->stage == 1 || Session::get('session-hop')) {
            return $next($request);
        }
        Auth::logout();
        return redirect('/login')->with(session()->flash('alert-warning', 'Profile is locked. Contact your administrator'));
    }
}
