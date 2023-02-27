<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Handle404
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response->getStatusCode() == 404) {
            // Vlastní zpráva pro chybějící endpoint
            return response()->json(['status' => false, 'message' => 'Tento endpoint neexistuje'], 404);
        }

        return $response;
    }
}
