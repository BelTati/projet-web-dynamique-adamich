<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validation des champs
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'L\'adresse email est obligatoire.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        // 2. Tentative d'authentification
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            
            $user = Auth::user();

            // Vérification si l'utilisateur est banni (selon votre schéma)
            if ($user->est_banni) {
                Auth::logout();
                return back()->withErrors(['email' => 'Ce compte a été suspendu.']);
            }

            $request->session()->regenerate();

            // 3. Redirection selon le RÔLE
            return match($user->role) {
                'ADMIN'    => redirect()->route('admin.dashboard')->with('success', 'Bienvenue dans l\'administration.'),
                'PROVIDER' => redirect()->route('provider.dashboard')->with('success', 'Espace prestataire connecté.'),
                'USER'     => redirect('/')->with('success', 'Heureux de vous revoir !'),
                default    => redirect('/'),
            };
        }

        // 4. Échec : retour avec message
        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('info', 'Vous avez été déconnecté.');
    }
}





