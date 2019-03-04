<?php

namespace App\Http\Middleware;

use Closure,Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ... $roles)
    {
        /*if (!Auth::check() )
		{
            return redirect('auth.login');
		}
        return $next($request);*/
        
        if (!Auth::check()) // I included this check because you have it, but it really should be part of your 'auth' middleware, most likely added as part of a route group.
            return redirect('login');
    
        $user = Auth::user();
    
        foreach($roles as $role) {
            // Check if user has the role This check will depend on how your roles are set up
            if($user->rol==$role){
                return $next($request);
            }
        }
        
        return redirect('login');
    }
}
