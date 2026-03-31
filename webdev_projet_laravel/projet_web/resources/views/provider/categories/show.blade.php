@extends('layouts.default')
<h3>Déscription</h3>
   
@section('content')
    <div class="service-description">
        <h1>{{ $categories->nom }}</h1>
        <p class="description">{{ $categories->description }}</p>
        
        @if($categories->mise_en_avant)
            <span class="badge">Service Recommandé</span>
        @endif
    </div>
@endsection

                