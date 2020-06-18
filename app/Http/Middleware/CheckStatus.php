<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route = $request->route();

        if ((Auth::user()->is_approved == 0) && ($route->uri != 'not-approved')) {

            return redirect('/not-approved');
        }
        return $next($request);
    }
}
