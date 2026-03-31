@extends('layouts.default')

@section('content')
<div class="container mt-5 mb-5">
    <div class="card shadow-sm border-0 overflow-hidden">
        <!-- Header : Nom et Photo/Logo -->
        <div class="card-header bg-primary text-white p-4">
            <div class="d-flex align-items-center flex-wrap">
                <img src="{{ $prestataire->logo ? asset('storage/' . $prestataire->logo) : asset('assets/img/default-avatar.png') }}" 
                     alt="Logo de {{ $prestataire->nom }}" 
                     class="rounded-circle border border-white shadow-sm me-4" 
                     style="width: 120px; height: 120px; object-fit: cover;">
                
                <div>
                    <h1 class="display-5 mb-0">{{ $prestataire->nom }} {{ $prestataire->prenom }}</h1>
                    <span class="badge bg-light text-primary mt-2">Prestataire Bien-être</span>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="row">
                <!-- Colonne de gauche : Description -->
                <div class="col-md-7 border-end">
                    <h3 class="h5 border-bottom pb-2">Description</h3>
                    <p class="text-muted leading-relaxed">
                        {{ $prestataire->description ?? 'Ce prestataire n\'a pas encore rédigé de description.' }}
                    </p>
                </div>

                <!-- Colonne de droite : Coordonnées (Requirements) -->
                <div class="col-md-5 ps-md-4">
                    <h3 class="h5 border-bottom pb-2">Coordonnées</h3>
                    
                    <ul class="list-unstyled">
                        <!-- Adresse Physique (Relation adresses) -->
                        <li class="mb-3">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i>
                            <strong>Adresse :</strong><br>
                            <span class="ms-4 text-muted">
                                {{ $prestataire->adresses->rue }} {{ $prestataire->adresses->numero }},<br>
                                {{ $prestataire->adresses->cp }} {{ $prestataire->adresses->ville }}
                            </span>
                        </li>

                        <!-- Email -->
                        <li class="mb-3">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <strong>Email :</strong><br>
                            <a href="mailto:{{ $prestataire->email }}" class="ms-4 text-decoration-none">{{ $prestataire->email }}</a>
                        </li>

                        <!-- GSM / Mobile -->
                        <li class="mb-3">
                            <i class="fas fa-phone-alt text-success me-2"></i>
                            <strong>GSM :</strong><br>
                            <span class="ms-4 text-muted">{{ $prestataire->telephone_mobile ?? 'Non renseigné' }}</span>
                        </li>

                        <!-- TVA -->
                        <li class="mb-3">
                            <i class="fas fa-file-invoice text-warning me-2"></i>
                            <strong>Numéro de TVA :</strong><br>
                            <span class="ms-4 text-muted">{{ $prestataire->tva ?? 'Non assujetti' }}</span>
                        </li>

                        <!-- Site Officiel -->
                        <li class="mb-3">
                            <i class="fas fa-globe text-info me-2"></i>
                            <strong>Site web :</strong><br>
                            <a href="{{ $prestataire->site_web }}" target="_blank" class="ms-4 text-decoration-none">
                                {{ $prestataire->site_web ?? 'Aucun site renseigné' }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-footer bg-light text-center py-3">
            <a href="{{ route('provider.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour à l'annuaire
            </a>
        </div>
    </div>
</div>

</div>
@endsection
