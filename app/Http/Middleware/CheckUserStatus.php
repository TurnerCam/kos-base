<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

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
