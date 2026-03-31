<p>Bonjour {{ $user->prenom }},</p>
<p>Merci pour votre inscription. Veuillez cliquer sur le lien ci-dessous pour confirmer votre compte :</p>
<a href="{{ route('confirm.register', ['token' => $user->inscription_confirmation_token]) }}">
    Confirmer mon inscription
</a>