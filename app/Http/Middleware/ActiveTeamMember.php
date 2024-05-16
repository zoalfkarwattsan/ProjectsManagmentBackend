<?php

namespace App\Http\Middleware;

use Closure;

class ActiveTeamMember
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user()->active) {
            return response()->json(['msg' => 'Deactivated member'], 403);
        }
        return $next($request);
    }
}
