@extends('layouts.default')
@section('content')
   
      
<main class="col-md-10">
      @include('include.slider')  
<div>
    <div class="container mt-5">
    <div class="row align-items-center">
        <!-- Colonne pour l'image -->
        
        <!-- Colonne pour la zone de recherche -->
        <div class="container mt-4">
            <div class="row align-items-center"> <!-- Alignement vertical centré -->
                <div class="col-md-8"> <!-- Zone de recherche (prend 8 colonnes sur médiums+) -->
                    
                    <div class="input-group">   
                        <input type="search" class="form-control" placeholder="Rechercher...">
                        <button class="btn btn-primary" type="button">
                            button
                        </button>
                    </div>
                
                </div>
                
                <div class="col-md-4"> <!-- Image (prend 4 colonnes sur médiums+) -->
                    <img src="images/service.jpg" alt="Description de l'image" class="img-fluid float-right">
                </div>
            </div>
        
               

        </div>
        </div>
 



<!--

    <div class="row">
        <div class="input-group col-md-6">
            <span class="input-group-text" id="basic-addon1">Titre de tache</span>
            <input
                type="text"
                class="form-control"
                placeholder="title"
                aria-label="title"
                aria-describedby="basic-addon1"
                name="title"
            />
        </div>
       <div class="input-group col-md-6">   
            <img id="" class="" src="images/service.jpg" alt="" />
     </div>
   </div>  
-->

</div>
</main>

@endsection