@extends('layouts.default')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
    <h2 class="text-2xl font-bold text-indigo-900 mb-6">Nouvelle Catégorie de Service</h2>

    <form action="{{ route('provider.categories.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Nom de la catégorie</label>
            <input type="text" name="nom" value="{{ old('nom') }}" 
                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" 
                   placeholder="Ex: Sophrologie" required>
            @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="4" 
                      class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" 
                      placeholder="Décrivez l'utilité de cette catégorie...">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center space-x-4 pt-4">
            <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-6 rounded hover:bg-indigo-700 transition">
                Enregistrer la catégorie
            </button>
            <a href="{{ route('provider.categories.index') }}" class="text-gray-500 hover:underline">Annuler</a>
        </div>
    </form>
</div>
@endsection