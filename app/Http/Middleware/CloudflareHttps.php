<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class CloudflareHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->setTrustedProxies([$request->getClientIp()], Request::HEADER_X_FORWARDED_ALL);
        if (!$request->secure()) {
            return redirect()->secure($request->getRequestUri());
        }
        return $next($request);
    }
}
