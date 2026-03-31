<?php
namespace App\Mail;

use App\Models\Categorie;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class CategoryTransferredMail extends Mailable
{
    use Queueable, SerializesModels;

    // On passe l'ancienne et la nouvelle catégorie au mail
    public function __construct(
        public Categorie $oldCategory,
        public Categorie $newCategory
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mise à jour de votre catégorie de service',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.category-transferred',
        );
    }
}
