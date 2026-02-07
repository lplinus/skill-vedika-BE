<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $csp = "
            default-src 'self';
            script-src 'self' 'unsafe-inline' 'unsafe-eval'
                https://www.googletagmanager.com
                https://www.google-analytics.com;
            connect-src 'self'
                http://127.0.0.1:8000
                http://localhost:8000
                http://localhost:3001
                http://10.2.0.2:3001
                https://www.google.com
                https://www.gstatic.com
                https://www.google-analytics.com
                https://region1.google-analytics.com
                https://www.googletagmanager.com;
            img-src 'self' data: blob:
                https://www.google-analytics.com
                https://www.googletagmanager.com;
            style-src 'self' 'unsafe-inline';
            font-src 'self' data:;
        ";

        $response->headers->set(
            'Content-Security-Policy',
            preg_replace('/\s+/', ' ', trim($csp))
        );

        return $response;
    }
}
