<?php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class ConfirmationInscription extends Mailable
{
    use Queueable, SerializesModels;

    // 1. DÉCLARER LA PROPRIÉTÉ PUBLIQUE ICI
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        // 2. ASSIGNER L'UTILISATEUR
        $this->user = $user;
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.confirmation', // Vérifiez que ce fichier existe
        );
    }

    // ... reste du code (envelope, attachments)
}