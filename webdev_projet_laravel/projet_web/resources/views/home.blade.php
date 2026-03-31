@extends('layouts.default')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Nouveaux prestataires</h2>
    <div class="row">
        @foreach($prestataires as $prestataire)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ $prestataire->nom }} {{ $prestataire->prenom }}</h5>
                        
                        <!-- AFFICHAGE DES CATÉGORIES -->
                        <div class="mb-2">
                            @forelse($prestataire->categories as $cat)
                                <span class="badge bg-info text-dark fw-normal" style="font-size: 0.75rem;">
                                    {{ $cat->nom }}
                                </span>
                            @empty
                                <span class="text-muted small italic">Aucun service</span>
                            @endforelse
                        </div>

                        <p class="card-text text-muted small">
                            <i class="fas fa-map-marker-alt"></i> {{ $prestataire->adresses->ville ?? 'Ville non précisée' }}
                        </p>
                        
                        <a href="{{ route('provider.show', $prestataire->id) }}" class="btn btn-outline-primary btn-sm w-100">
                            Voir le profil
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
