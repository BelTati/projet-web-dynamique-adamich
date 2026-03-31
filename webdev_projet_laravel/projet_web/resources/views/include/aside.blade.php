<aside class="w-64 bg-light border-end p-3">
    <h5 class="fw-bold mb-3">Catégories Bien-être</h5>
    <ul class="list-group list-group-flush">
        @foreach($categories as $category)
            <li class="list-group-item bg-transparent">
                <a href="{{ route('categories.show', $category->id) }}" class="text-decoration-none text-dark hover-primary">
                    {{ $category->nom }}
                    @if($category->mise_en_avant)
                        <span class="badge bg-warning text-dark ms-1">Star</span>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</aside>
 

