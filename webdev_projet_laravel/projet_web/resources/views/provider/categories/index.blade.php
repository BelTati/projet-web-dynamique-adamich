@extends('layouts.default')

@section('content')
<div class="p-6 max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Catégories de Services</h1>
        <a href="{{ route('provider.dashboard') }}" class="text-indigo-600 hover:underline">← Retour au Dashboard</a>
    </div>
    
    <!-- BOUTON CRÉER -->
    <a href="{{ route('provider.categories.create') }}" 
       class="bg-green-600 hover:bg-green-700 text-black font-bold py-2 px-4 rounded shadow transition">
       + Créer une catégorie officielle
    </a>
</div>
    <!-- SECTION 2 : CATALOGUE OFFICIEL (MODIFIER / SUPPRIMER) -->
    <div class="bg-white p-6 shadow-lg rounded-lg border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Catégories actives</h2>
        <table class="w-full">
            <thead>
                <tr class="text-gray-400 text-xs uppercase border-b">
                    <th class="pb-3">Nom (Modifier en direct)</th>
                    <th class="pb-3 text-right">Actions / Transfert</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($validated as $cat)
                <tr>
                    <td class="py-4">
                        <!-- FORMULAIRE POUR RENOMMER -->
                        <form action="{{ route('provider.categories.update', $cat->id) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                             @method('PATCH')
                            <input type="text" name="nom" value="{{ old('nom', $cat->nom) }}" 
                                   class="text-sm border-gray-300 rounded-md focus:ring-indigo-500 py-1 px-2 w-64">
                            <button type="submit" class="text-indigo-600 hover:text-indigo-800 text-xs font-bold uppercase">Mettre à jour</button>
                        </form>
                        <span class="text-xs text-gray-400 mt-1 block">{{ $cat->users_count }} prestataires liés</span>
                    </td>
                    <td class="py-4 text-right">
                        <!-- FORMULAIRE SUPPRIMER AVEC TRANSFERT -->
                        <form action="{{ route('provider.categories.destroy', $cat->id) }}" method="POST" class="inline-flex items-center gap-2">
                            @csrf @method('DELETE')
                            
                            @if($cat->users_count > 0)
                                <div class="flex flex-col items-end">
                                    <label class="text-[10px] text-red-500 font-bold uppercase mb-1">Transférer vers :</label>
                                    <select name="transfer_to" class="text-xs border-gray-300 rounded p-1 w-40" required>
                                        <option value="">Choisir...</option>
                                        @foreach($validated as $dest)
                                            @if($dest->id !== $cat->id)
                                                <option value="{{ $dest->id }}">{{ $dest->nom }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            
                            <button type="submit" 
                                    class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1 rounded text-xs font-bold transition border border-red-200" 
                                    onclick="return confirm('Attention : Cette action est irréversible. Confirmer ?')">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection