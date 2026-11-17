<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {

        // This method ensures that only active and hiatus users remain logged in
        if (! Auth::guest()) {
            // if user was deactivated while logged in, boot them out
            if ((\Auth::user()->status != 'active') && (\Auth::user()->status != 'hiatus')) {
                Auth::logout();

                return redirect('/login')->with('error', 'Your account is no longer active.');
            }
        }

        return $next($request);
    }
}
