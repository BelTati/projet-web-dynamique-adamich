@component('mail::message')
# Nouveau message de {{ $data['nom'] }}

Vous avez reçu une demande de contact depuis votre fiche prestataire.

**Sujet :** {{ $data['sujet'] }}

**Message :**
{{ $data['message'] }}

@component('mail::button', ['url' => route('login')])
Se connecter à mon espace
@endcomponent

Répondre à : [{{ $data['email'] }}](mailto:{{ $data['email'] }})

Cordialement,<br>
L'équipe {{ config('app.name') }}
@endcomponent
