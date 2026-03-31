<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Adresse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmationInscription;
use Illuminate\View\View;


class RegisterController extends Controller
{
    /**
     * ÉTAPE 1 : Inscription simplifiée (Nom, Prénom, Email, Rôle)
     */
    public function register(Request $request) 
    {
        // Validation stricte incluant le rôle choisi
        $request->validate([
            'nom'    => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'email'  => 'required|email|unique:users',
            'role'   => 'required|in:USER,PROVIDER', // Différenciation ici
        ]);

        $token = Str::random(64);

        $user = User::create([
            'nom'                            => $request->nom,
            'prenom'                         => $request->prenom,
            'email'                          => $request->email,
            'password'                       => Hash::make(Str::random(16)), // Mot de passe provisoire
            'role'                           => $request->role, 
            'inscription_confirmation_token' => $token,
        ]);

        // Envoi de l'email de confirmation (CU02)
        Mail::to($user->email)->send(new ConfirmationInscription($user));

        return redirect('/login')->with('info', 'Un email de confirmation vous a été envoyé pour finaliser votre profil.');
    }

    /**
     * ÉTAPE 2 : Affichage du formulaire de confirmation (Clic sur le lien mail)
     * On différencie la vue selon le rôle stocké en base de données.
     */
    public function showConfirmationForm($token): View
    {
        $user = User::where('inscription_confirmation_token', $token)->firstOrFail();

        // Si c'est un prestataire, on affiche la fiche complète (TVA, GSM, etc.)
        if ($user->role === 'PROVIDER') {
            return view('auth.finalize_provider', compact('user'));
        }

        // Sinon, on affiche la fiche standard pour l'internaute
        return view('auth.finalize_user', compact('user'));
    }

    /**
     * ÉTAPE 3 : Finalisation et enregistrement des données complètes
     */
    public function finalizeRegistration(Request $request, $token) 
    {
        $user = User::where('inscription_confirmation_token', $token)->firstOrFail();

        // Validation commune + champs spécifiques si prestataire
        $rules = [
            'password' => 'required|min:8|confirmed',
            'rue'      => 'required|string',
            'numéro'   => 'required|string',
            'ville'    => 'required|string',
            'cp'       => 'required|string',
            'pays'     => 'required|string',
        ];

        if ($user->role === 'PROVIDER') {
            $rules['tva'] = 'required|string';
            $rules['telephone_mobile'] = 'required|string';
            $rules['site_web'] = 'nullable|url';
        }

        $request->validate($rules);

        // 1. Création de l'adresse physique
        $adresse = Adresse::create([
            'rue'    => $request->rue,
            'numéro' => $request->numéro,
            'ville'  => $request->ville,
            'cp'     => $request->cp,
            'pays'   => $request->pays,
            'boîte'  => $request->boîte,
        ]);

        // 2. Mise à jour finale de l'utilisateur
        $user->update([
            'nom'                            => $request->nom, 
            'prenom'                         => $request->prenom,
            'password'                       => Hash::make($request->password),
            'adresse_id'                     => $adresse->id,
            'tva'                            => $request->tva,
            'telephone_mobile'               => $request->telephone_mobile,
            'site_web'                       => $request->site_web,
            'email_verified_at'              => now(), // Confirmation technique
            'inscription_confirmation_token' => null,  // Sécurité : on vide le token
        ]);

        // Connexion automatique après finalisation
      
        auth()->login($user);

        // Redirection basée sur le rôle défini lors de l'étape 2
        if ($user->role === 'PROVIDER') {
            return redirect()->route('provider.dashboard')
                ->with('success', 'Bienvenue sur votre espace prestataire !');
        }

        return redirect('/')->with('success', 'Votre compte client est désormais actif !');

                
            }
}
