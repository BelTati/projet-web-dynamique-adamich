<h3>Déscription</h3>
    

  
        

             @foreach($categories as $category)
                <h3>{{ $category->nom }}</h3>
                <p>{{ $category->description }}</p>
      
   @endforeach