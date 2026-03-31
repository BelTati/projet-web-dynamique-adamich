<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsProvider
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       // return $next($request);
        // On vérifie si l'utilisateur est connecté ET si son rôle est PROVIDER
    if (auth()->check() && auth()->user()->role === 'PROVIDER') {
        return $next($request);
    }

    // Sinon, redirection vers l'accueil avec un message d'erreur
    return redirect('/')->with('error', 'Accès réservé aux prestataires.');
    }

    
}
