@extends('layouts.default')
@section('content')
         
<div class="container mt-5">
    <div class="row align-items-center">
            <!-- Zone de recherche (Gauche) -->
         <div class="col-md-8">       
            <a href="{{ route('provider.categories.index') }}" 
            class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-bleu font-bold rounded-md shadow transition duration-150">
                Gérer les catégories
            </a>
        </div>
    </div>
</div>

@endsection