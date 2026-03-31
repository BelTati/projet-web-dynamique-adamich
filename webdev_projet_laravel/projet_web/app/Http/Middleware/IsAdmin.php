<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //return $next($request);
       
        // On vérifie si l'utilisateur est ADMIN (selon votre énumération 'ADMIN')
   /*
        if (auth()->check() && auth()->user()->role === 'ADMIN') {
        return $next($request);
    }
*/ 
      // 1. Vérifier si l'utilisateur est connecté ET s'il est ADMIN
     
        if (Auth::check() && Auth::user()->role === 'ADMIN') {
            return $next($request); // L'accès est autorisé, on continue
        }  

   
    
        // Redirection si l'utilisateur n'est pas admin
    return redirect('/')->with('error', 'Accès réservé aux administrateurs.');
    }
    
}
