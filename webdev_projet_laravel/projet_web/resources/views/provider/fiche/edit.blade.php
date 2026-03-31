@extends('layouts.default')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <h1 class="text-3xl font-bold mb-6 text-indigo-800">Ma Fiche Signalétique</h1>

    @if(session('status'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('provider.fiche.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8 bg-white p-8 shadow-lg rounded-lg">
        @csrf

        <!-- SECTION 1 : IDENTITÉ & LOGO -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nom de l'établissement / Prénom Nom</label>
                <input type="text" name="nom" value="{{ old('nom', $user->nom) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Logo (Carré conseillé)</label>
                <div class="flex items-center space-x-4">
                    @if($user->logo)
                        <img src="{{ asset('storage/' . $user->logo) }}" class="w-12 h-12 rounded shadow">
                    @endif
                    <input type="file" name="logo" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-indigo-50 file:text-indigo-700">
                </div>
            </div>
        </div>

        <!-- SECTION 2 : INFOS STANDARDS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Téléphone Mobile</label>
                <input type="text" name="telephone" value="{{ old('telephone', $user->telephone_mobile) }}" class="w-full border-gray-300 rounded-md">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Numéro de TVA</label>
                <input type="text" name="tva" value="{{ old('tva', $user->tva) }}" class="w-full border-gray-300 rounded-md" placeholder="BE0XXX.XXX.XXX">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Site Web Officiel</label>
                <input type="url" name="site_web" value="{{ old('site_web', $user->site_web) }}" class="w-full border-gray-300 rounded-md" placeholder="https://...">
            </div>
        </div>

        <!-- SECTION 3 : DESCRIPTION -->
        
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Description de vos services</label>
            <textarea name="description" rows="4" class="w-full border-gray-300 rounded-md">{{ old('description', $user->description) }}</textarea>
        </div>

        <!-- SECTION 4 : PHOTOS DU SLIDER -->
        <div class="bg-indigo-50 p-6 rounded-md">
            <h3 class="text-lg font-semibold text-indigo-900 mb-4 italic">Photos de présentation (Slider)</h3>
            <input type="file" name="photos[]" multiple class="block w-full text-sm text-gray-500">
            <p class="text-xs text-indigo-600 mt-2">Sélectionnez plusieurs fichiers pour alimenter votre galerie d'images.</p>
            
            @if($user->photos && $user->photos->count() > 0)
                <div class="flex mt-4 space-x-2 overflow-x-auto pb-2">
                    @foreach($user->photos as $photo)
                        <img src="{{ asset('storage/' . $photo->path) }}" class="h-20 w-20 object-cover rounded border">
                    @endforeach
                </div>
            @endif
        </div>
        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
    <h3 class="text-lg font-bold text-indigo-800 mb-4">Mes Catégories de Services</h3>
    <p class="text-sm text-gray-600 mb-4 italic">
        Cochez les catégories dans lesquelles vous souhaitez apparaître dans l'annuaire.
    </p>

    <!-- Liste des catégories existantes (validées) -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
        @foreach($categories as $category)
            <label class="flex items-center space-x-3 p-2 bg-white rounded border border-gray-100 hover:bg-indigo-50 cursor-pointer transition">
                <input type="checkbox" 
                       name="categories[]" 
                       value="{{ $category->id }}"
                       class="rounded text-indigo-600 focus:ring-indigo-500"
                       {{ $user->categories->contains($category->id) ? 'checked' : '' }}>
                <span class="text-sm text-gray-700">{{ $category->nom }}</span>
            </label>
        @endforeach
    </div>
            <!-- Suggestion d'une nouvelle catégorie -->
    <div class="border-t border-gray-200 pt-4">
        <label class="block text-sm font-bold text-gray-700 mb-2">
                 Une catégorie manque à l'appel ? Proposez-la :
        </label>
         <div class="flex gap-2">
             <input type="text" 
                 name="new_category" 
                class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" 
                placeholder="Ex: Sophrologie, Reiki, Massothérapie...">
            <span class="inline-flex items-center px-3 rounded-md border border-transparent bg-gray-200 text-gray-600 text-xs italic">
                    Sera soumis à validation
             </span>
        </div>
        @error('new_category')
                 <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
     </div>
    </div>
        <!-- SECTION 5 : SÉCURITÉ (MOT DE PASSE) -->
        <div class="border-t pt-6">
            <h3 class="text-lg font-bold text-red-700 mb-4">Sécurité du compte</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nouveau mot de passe</label>
                    <input type="password" name="password" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Laisser vide pour ne pas changer">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('home') }}" class="px-6 py-2 border rounded-md text-red-600 hover:bg-gray-100">Annuler</a>
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-black font-bold rounded-md hover:bg-indigo-700 transition">
                Enregistrer ma fiche prestataire
            </button>
        </div>
    </form>
</div>
@endsection