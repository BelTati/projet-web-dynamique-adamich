@component('mail::message')
# Bonjour,

Nous vous informons qu'un changement a été effectué sur l'annuaire concernant vos services.

La catégorie **"{{ $oldCategory->nom }}"** a été supprimée ou fusionnée pour améliorer la clarté de notre plateforme.

En conséquence, votre profil a été automatiquement transféré vers la catégorie suivante :
**"{{ $newCategory->nom }}"**.

@component('mail::button', ['url' => route('home')])
Voir l'annuaire
@endcomponent

Si ce changement ne vous convient pas, vous pouvez modifier vos catégories à tout moment depuis votre fiche signalétique.

Cordialement,<br>
L'administration de {{ config('app.name') }}
@endcomponent
