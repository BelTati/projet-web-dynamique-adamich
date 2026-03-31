@extends('layouts.default')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-indigo-900">Nos Prestataires Bien-être</h1>
        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
            {{ $prestataires->total() }} professionnels trouvés
        </span>
    </div>

    <!-- GRILLE DES PRESTATAIRES -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($prestataires as $p)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-300">
                <!-- Header de la carte (Logo & Nom) -->
                <div class="p-6 flex items-center space-x-4 border-b border-gray-50">
                    <div class="flex-shrink-0">
                        @if($p->logo)
                            <img src="{{ asset('storage/' . $p->logo) }}" alt="Logo {{ $p->nom }}" class="w-16 h-16 rounded-lg object-cover shadow-sm">
                        @else
                            <div class="w-16 h-16 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-500 font-bold text-xl uppercase">
                                {{ substr($p->nom, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 leading-tight">{{ $p->nom }}</h3>
                        <p class="text-sm text-indigo-600 font-medium">Prestataire vérifié</p>
                    </div>
                </div>

                <!-- Corps de la carte -->
                <div class="p-6 space-y-4">
                    <p class="text-gray-600 text-sm line-clamp-3">
                        {{ $p->description ?? 'Ce prestataire n\'a pas encore rédigé de description.' }}
                    </p>

                    <div class="flex flex-wrap gap-2">
                        @foreach($p->categories->take(3) as $cat)
                            <span class="text-[10px] uppercase font-bold px-2 py-1 bg-gray-100 text-gray-600 rounded">
                                {{ $cat->nom }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Footer de la carte (Actions) -->
                <div class="p-4 bg-gray-50 flex justify-between items-center">
                    <a href="{{ route('provider.show', $p->id) }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800">
                        Voir profil
                    </a>
                    <a href="{{ route('provider.contact', $p->id) }}" class="bg-indigo-600 text-black px-4 py-2 rounded-lg text-xs font-bold hover:bg-indigo-700 transition">
                        Contacter
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 italic">Aucun prestataire ne correspond à votre recherche pour le moment.</p>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    <div class="mt-12">
        {{ $prestataires->links() }}
    </div>
</div>
@endsection
