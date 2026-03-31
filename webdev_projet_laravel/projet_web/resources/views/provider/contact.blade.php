@extends('layouts.default')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="bg-indigo-900 p-6 text-white text-center">
            <h1 class="text-2xl font-bold text-white">Contacter {{ $prestataire->nom }}</h1>
            <p class="text-indigo-200 text-sm mt-1">Votre message sera envoyé directement par email au prestataire.</p>
        </div>

        <form action="{{ route('contact.send', $prestataire->id) }}" method="POST" class="p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
               <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Votre Nom / Prénom</label>
                    <input type="text" name="nom" 
                        value="{{ old('nom', auth()->check() ? auth()->user()->nom : '') }}" 
                        {{ auth()->check() ? 'readonly' : 'required' }}
                        class="w-full border-gray-300 rounded-lg bg-gray-50">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Votre Email</label>
                    <input type="email" name="email" 
                        value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}" 
                        {{ auth()->check() ? 'readonly' : 'required' }}
                        class="w-full border-gray-300 rounded-lg bg-gray-50">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Sujet du message</label>
                <input type="text" name="sujet" value="{{ old('sujet') }}" required
                       class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="Ex: Demande de renseignements pour un stage">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Votre Message</label>
                <textarea name="message" rows="6" required
                          class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                          placeholder="Écrivez votre message ici...">{{ old('message') }}</textarea>
            </div>

            <div class="flex items-center justify-between pt-4">
                <a href="{{ route('provider.show', $prestataire->id) }}" class="text-gray-500 hover:underline text-sm">
                    ← Annuler et retourner au profil
                </a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition">
                    Envoyer l'email
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
