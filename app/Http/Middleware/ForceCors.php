<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Hard CORS middleware to unblock Vercel frontends.
 * - Reflects allowed Origin (so it works with many Vercel preview URLs)
 * - Handles OPTIONS preflight early with a 204 response
 *
 * This is intentionally permissive for *.vercel.app + localhost.
 */
class ForceCors
{
    private function isAllowedOrigin(?string $origin): bool
    {
        if (!$origin) return false;

        if ($origin === 'http://localhost:5173') return true;
        if ($origin === 'http://localhost:3000') return true;

        // Allow all Vercel preview + production domains
        if (preg_match('#^https://.*\.vercel\.app$#', $origin)) return true;

        return false;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $origin = $request->headers->get('Origin');
        $allowed = $this->isAllowedOrigin($origin);

        $allowHeaders = $request->headers->get('Access-Control-Request-Headers')
            ?: 'Content-Type, Authorization, X-Salon-Id, Accept, Origin, X-Requested-With';

        $headers = [
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => $allowHeaders,
            'Access-Control-Max-Age' => '86400',
        ];

        if ($allowed) {
            $headers['Access-Control-Allow-Origin'] = $origin;
            $headers['Vary'] = 'Origin';
        }

        // Preflight
        if ($request->getMethod() === 'OPTIONS') {
            return response('', 204)->withHeaders($headers);
        }

        /** @var Response $response */
        $response = $next($request);

        foreach ($headers as $k => $v) {
            if (!$response->headers->has($k)) {
                $response->headers->set($k, $v);
            }
        }

        // Always reflect allowed origin on non-OPTIONS responses too
        if ($allowed) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Vary', 'Origin');
        }

        return $response;
    }
}


