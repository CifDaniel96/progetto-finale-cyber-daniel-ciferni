<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FrameGuard
{
    public function handle(Request $request, Closure $next): Response
{
    $response = $next($request);

    $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
    $response->headers->set('Content-Security-Policy', "frame-ancestors 'self'");
    $response->headers->set('X-Content-Type-Options', 'nosniff');
    $response->headers->remove('X-Powered-By');

    if (function_exists('header_remove')) {
        header_remove('X-Powered-By');
    }

    return $response;
}
}
