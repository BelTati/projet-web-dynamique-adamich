@extends('layouts.default')

@section('content')
<div class="container mx-auto p-6 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Mon Profil Bien-être</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf

        <!-- Affichage de l'avatar actuel -->
        <div class="mb-6 flex items-center space-x-4">
            <div class="shrink-0">
                <img class="h-16 w-16 object-cover rounded-full border-2 border-indigo-500" 
                     src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}" 
                     alt="Avatar">
            </div>
            <label class="block">
                <span class="sr-only">Choisir une photo de profil</span>
                <input type="file" name="avatar" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
            </label>
            @error('avatar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Champ Nom -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="nom">Nom</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                   id="nom" name="nom" type="text" value="{{ old('nom', $user->nom) }}" required>
            @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Champ Prénom -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="prenom">Prénom</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                   id="prenom" name="prenom" type="text" value="{{ old('prenom', $user->prenom) }}" required>
            @error('prenom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Champ Email (Lecture seule - Requirement) -->
        <div class="mb-6">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="email">Email (Identifiant non modifiable)</label>
            <input class="bg-gray-100 border rounded w-full py-2 px-3 text-gray-500 cursor-not-allowed" 
                   id="email" type="email" value="{{ $user->email }}" disabled>
        </div>
        <!-- SECTION ADRESSE (Requirement) -->
<div class="mt-8 pt-6 border-t border-gray-200">
    <h2 class="text-lg font-bold mb-4 text-gray-700">Mon Adresse de contact</h2>
    
    <div class="grid grid-cols-6 gap-4">
        <!-- Rue -->
        <div class="col-span-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Rue</label>
            <input type="text" name="rue" value="{{ old('rue', $user->adresses->rue ?? '') }}" 
                   class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Numéro -->
        <div class="col-span-2">
    <label class="block text-gray-700 text-sm font-bold mb-2">N°</label>
    <input type="text" name="numéro" value="{{ old('numéro', $user->adresses->numéro ?? '') }}" 
           class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
    @error('numéro') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

        <!-- Code Postal -->
        <div class="col-span-2">
            <label class="block text-gray-700 text-sm font-bold mb-2">Code Postal</label>
            <input type="text" name="cp" value="{{ old('cp', $user->adresses->cp ?? '') }}" 
                   class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Ville -->
        <div class="col-span-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Ville</label>
            <input type="text" name="ville" value="{{ old('ville', $user->adresses->ville ?? '') }}" 
                   class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
         <div class="col-span-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">pays</label>
            <input type="text" name="pays" value="{{ old('pays', $user->adresses->pays ?? '') }}" 
                   class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
         <div class="col-span-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">boîte </label>
            <input type="text" name="boîte" value="{{ old('boîte', $user->adresses->boîte  ?? '') }}" 
                   class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
    </div>
</div>

        <div class="flex items-center justify-between">
            <button class="bg-indigo-600 hover:bg-indigo-700 text-black font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-200" type="submit">
                Mettre à jour ma fiche
            </button>
        </div>
    </form>

</div>

@endsection