@extends('layouts.default')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Accueil Administrateur</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Bloc Gestion Catégories -->
        <div class="bg-white p-4 shadow rounded-lg border-t-4 border-blue-500">
            <h2 class="font-semibold text-lg">Gestion des Catégories</h2>
            <!-- LIEN ADMIN VERS LES PRESTATAIRES -->
                 <a href="{{ route('provider.index') }}" class="bg-white border-2 border-indigo-600 text-indigo-600 p-4 rounded shadow text-center font-bold hover:bg-indigo-50">
                Voir tous les prestataires
             </a>
            <p class="text-sm text-gray-600 mb-4">Ajouter, modifier ou valider les catégories de services.</p>
            <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:underline">
                Voir toutes les catégories &rarr;
            </a>
        </div>
        
         <!-- LE BOUTON DE REDIRECTION -->
        <a href="{{ route('admin.categories.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-md shadow transition duration-150">
            Gérer les catégories
        </a>
        <!-- SECTION : MODÉRATION DES SUGGESTIONS (Requirement) -->
<div class="bg-white shadow-lg rounded-lg overflow-hidden mb-8 border-l-4 border-yellow-500">
    <div class="bg-yellow-50 px-6 py-4 border-b border-yellow-100">
        <h2 class="text-xl font-bold text-yellow-800 flex items-center">
            Suggestions de catégories à valider
        </h2>
    </div>

    <div class="p-6">
        @if($pending->isEmpty())
            <p class="text-gray-500 italic text-sm">Aucune suggestion en attente pour le moment.</p>
        @else
            <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-400 text-xs uppercase tracking-wider">
                        <th class="pb-3">Nom proposé</th>
                        <th class="pb-3">Description</th>
                        <th class="pb-3">Par le prestataire</th>
                        <th class="pb-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($pending as $cat)
                        <tr>
                            <td class="py-4 font-semibold text-gray-800">{{ $cat->nom }}</td>
                            <td class="py-4 text-sm text-gray-600">{{ Str::limit($cat->description, 50) }}</td>
                            <td class="py-4 text-sm">{{ $cat->user->nom ?? 'Inconnu' }}</td>
                            <td class="py-4 text-right space-x-2">
                                <!-- BOUTON VALIDER (Action directe) -->
                                <form action="{{ route('admin.categories.validate', $cat->id) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="valide" value="1">
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs font-bold transition">
                                        Valider
                                    </button>
                                </form>

                                <!-- BOUTON MODIFIER (Si fautes d'orthographe) -->
                                <a href="{{ route('admin.categories.edit', $cat->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-bold transition">
                                    Modifier
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
        <!-- Autres blocs (Validation prestataires, etc.) -->
    </div>
</div>
@endsection

      

      
