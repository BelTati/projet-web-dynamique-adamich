@extends('layouts.default')

@section('content')
@csrf
    <h3 class="text-xl font-bold mb-4">Contacter ce prestataire</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <input type="text" name="nom" placeholder="Votre nom" class="border p-2 rounded" required>
        <input type="email" name="email" placeholder="Votre email" class="border p-2 rounded" required>
    </div>
    
    <input type="text" name="sujet" placeholder="Sujet de votre message" class="border p-2 rounded w-full mb-4" required>
    <textarea name="message" rows="4" placeholder="Votre message..." class="border p-2 rounded w-full mb-4" required></textarea>

    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
        Envoyer le mail
    </button>
@endsection