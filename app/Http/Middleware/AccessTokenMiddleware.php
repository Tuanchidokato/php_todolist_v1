<?php

namespace App\Http\Middleware;

use App\Models\AccessToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $authorization = $request->header('Authorization');
        $accessToken = AccessToken::where('access_token', $authorization)->first();
        if (!$accessToken) {
            return response()->json([ 'message' => 'Unauthorized' ], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
