@extends('layouts.default')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Résultats pour votre recherche</h1>

    @forelse($prestataires as $item)
        <div class="bg-white shadow-md rounded-xl overflow-hidden mb-6 border border-gray-100 flex flex-col md:flex-row">
            <!-- Info Gauche -->
            <div class="p-6 flex-1">
                <h2 class="text-xl font-bold text-indigo-900">{{ $item->nom }} {{ $item->prenom }}</h2>
                <div class="mt-2 flex flex-wrap gap-2">
                    @foreach($item->categories as $cat)
                        <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded-md text-xs font-semibold">
                            {{ $cat->nom }}
                        </span>
                    @endforeach
                </div>
                <p class="mt-3 text-gray-600 text-sm">
                    <i class="fas fa-map-marker-alt"></i> {{ $item->adresses->ville ?? 'Ville non renseignée' }}
                </p>
            </div>
            <!-- Action Droite -->
            <div class="p-6 bg-gray-50 flex items-center justify-center md:border-l">
                <a href="{{ route('provider.show', $item->id) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-bold transition">
                    Voir le profil
                </a>
            </div>
        </div>
    @empty
        <div class="text-center py-12 bg-white rounded-xl shadow">
            <p class="text-gray-500">Aucun prestataire ne correspond à "<strong>{{ request('search') }}</strong>".</p>
        </div>
    @endforelse

    <div class="mt-6">
        {{ $prestataires->links() }}
    </div>
</div>
@endsection
