<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {  
        /*echo $guard;
        exit;*/
        if (!Auth::guard($guard)->check()) {
            if($guard=="event_manager"){
                return redirect()->route('eventmanager.login');
            }else{
                return redirect()->route('admin.login');
            }            
        }
        // else if ($guard == "admin" && Auth::guard($guard)->check()) {
        //      // print_r(Auth::guard($guard)->check());die;
        //     return redirect()->route('admin.dashboard');
        // }
       /* if ($guard == "event_managers" && Auth::guard($guard)->check()) {
            return redirect('/writer');
        }
        if (Auth::guard($guard)->check()) {
            return redirect('/home');
        }*/

        return $next($request);


    }
}
