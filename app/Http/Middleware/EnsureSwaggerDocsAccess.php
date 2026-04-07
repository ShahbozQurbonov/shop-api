<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSwaggerDocsAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('swagger_docs_access_granted') === true) {
            return $next($request);
        }

        if ($request->is('docs') || $request->is('api/docs')) {
            return redirect()->route('docs.login', ['next' => url('/api/docs')]);
        }

        return response()->json([
            'success' => false,
            'status' => 'error',
            'message' => 'Барои Swagger токени махсус талаб мешавад',
        ], 401);
    }
}
