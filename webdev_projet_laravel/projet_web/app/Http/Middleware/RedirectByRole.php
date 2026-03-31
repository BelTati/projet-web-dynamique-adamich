<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectByRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Modifiez la constante HOME ou la logique de redirection
        if (Auth::guard($guard)->check()) {
            $user = Auth::user();
            if ($user->role === 'ADMIN') {
                return redirect()->route('admin.dashboard');
            }
            // ...
        }

        //return $next($request);
        
    }
    
}
