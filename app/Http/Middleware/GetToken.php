<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GetToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->header("authorization")) abort(403, "Authorization token not found");
        $token = str_replace("Bearer ", "", $request->header("authorization"));
        $request->headers->set("token", $token);
        return $next($request);
    }
}
