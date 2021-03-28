<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MustChangePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if(Auth::guard('admin')) {
            return $next($request);
        }
        
        if(Auth::guard('web')->user()->must_change_password) {
            return redirect()->route('changepswd');
        }

        return $next($request);
    }
}
