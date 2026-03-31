<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\ContactPrestataireMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    
public function show(User $prestataire)
{
    // On passe l'objet $prestataire à la vue pour savoir à QUI on écrit
    return view('contact', compact('prestataire'));
}
/**
     * Traite l'envoi du formulaire de contact vers un prestataire.
     */
    public function send(Request $request, User $prestataire)
    {
        // 1. Validation des données (Requirement)
        $validated = $request->validate([
            'nom'     => 'required|string|max:100',
            'email'   => 'required|email', // Email de l'internaute
            'sujet'   => 'required|string|max:150',
            'message' => 'required|string|min:10',
        ]);

        try {
            // 2. Envoi du mail au prestataire (Postcondition)
            // On passe les données validées à la classe Mailable
            Mail::to($prestataire->email)->send(new ContactPrestataireMail($validated));

            // 3. Succès : Retour sur la fiche signalétique (Postcondition)
            return back()->with('status', 'Votre message a été envoyé avec succès au prestataire.');

        } catch (\Exception $e) {
            // En cas d'échec technique (ex: serveur SMTP/Mailpit déconnecté)
            return back()
                ->withErrors(['mail' => "L'envoi du message a échoué. Veuillez réessayer plus tard."])
                ->withInput();
        }
    }
}
