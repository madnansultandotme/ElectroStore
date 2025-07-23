<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Force HTTP in local development environment
        if (env('APP_ENV') === 'local') {
            // Set the request to be non-secure (HTTP)
            $request->server->set('HTTPS', null);
            $request->server->set('SERVER_PORT', 9000);
            $request->server->set('REQUEST_SCHEME', 'http');
            
            // Ensure URL helper uses HTTP (only if config is available)
            if (function_exists('config')) {
                try {
                    config(['app.url' => 'http://127.0.0.1:9000']);
                } catch (\Exception $e) {
                    // Ignore config errors during bootstrap
                }
            }
            
            // Add headers to prevent HTTPS redirects
            $response = $next($request);
            
            // Remove any HSTS headers that might force HTTPS
            if (method_exists($response, 'headers') && $response->headers) {
                $response->headers->remove('Strict-Transport-Security');
                $response->headers->remove('Content-Security-Policy');
            }
            
            return $response;
        }
        
        return $next($request);
    }
}
