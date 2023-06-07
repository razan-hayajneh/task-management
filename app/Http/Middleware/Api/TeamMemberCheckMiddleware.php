<?php

namespace App\Http\Middleware\Api;
use Illuminate\Support\Facades\Route;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class TeamMemberCheckMiddleware
{

    public function handle($request, Closure $next)
    {
        if(auth()->user()->user_type!='team_member')
        {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized request',
            ], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
