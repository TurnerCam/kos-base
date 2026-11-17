<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Closure;

class HttpsProtocol
{
    public function handle(Request $request, Closure $next): Response
    {
        if (config('app.env') === 'production' && ! $request->secure()) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
