
  
  <!-- L'aside sera aligné au début (gauche) -->
  <aside class="me-6 col-md-2">
    <h3>Aside</h3>
    <p></p>
      
                 <ul>
                    @foreach($categories as $category)
                        <li>{{ $category->nom }}</li>
                         <a href="{{route("service", $category->id)}}">{{ $category->nom }}</a>
                    @endforeach
                </ul>
          
        <div>
          
        </div>
  </aside>

