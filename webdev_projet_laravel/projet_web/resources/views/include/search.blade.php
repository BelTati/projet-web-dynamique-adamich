  <div class="container mt-5">
        <div class="row align-items-center">
            <!-- Zone de recherche (Gauche) -->
            <div class="col-md-8">
                <h1 class="mb-4">Trouvez votre service de bien-être</h1>
                
                <form action="{{ route('provider.search') }}" method="GET">
                    <div class="input-group input-group-lg shadow-sm">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Un service, une ville, un nom..." 
                               value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                    </div>
                    <small class="text-muted mt-2 d-block">Exemple : Massage, Yoga, Namur...</small>
                </form>
            </div>
        </div>
    </div>