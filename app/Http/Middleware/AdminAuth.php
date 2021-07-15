<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Session;
class AdminAuth extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect(route('login'));
        }
        // if ($request->user() && $request->user()->roles != "admin")
        // {   
        //     Auth::logout();
        //     Session::flash('error', 'You do not have permission to access this link!');
        //     return redirect(route('login'));
        // }

        
        return $next($request);
    }
    
}
