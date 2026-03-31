<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary shadow-sm">
     
            <!-- Logo / Home -->
            <a class="navbar-brand font-bold text-primary" href="{{ route('home') }}">ZenApp</a>
            
           <div class="container">
                <!-- Menu de Gauche (Navigation générale) -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">À propos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Partenaires</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Par région</a></li>
                    <li class="nav-item"> 
                        <a class="nav-link" href="{{ route('provider.index') }}">
                            Trouver un prestataire 
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Stages</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                    
           </div>      
             <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Menu de Droite (Authentification & Rôles) -->
                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-primary me-2 px-3" href="{{ route('login') }}">S'identifier</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary text-white px-3" href="{{ route('register') }}">S'inscrire</a>
                        </li>
                    @else
                        <!-- 1. NAVIGATION ADMIN -->
                        @if(Auth::user()->role === 'ADMIN')
                            <li class="nav-item d-flex align-items-center border-end pe-3 me-3">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link text-danger fw-bold">Admin</a>
                            </li>
                        @endif

                        <!-- 2. NAVIGATION PRESTATAIRE -->
                        @if(Auth::user()->role === 'PROVIDER')
                            <li class="nav-item border-end pe-3 me-3">
                                <a href="{{ route('provider.fiche.edit') }}" class="nav-link text-primary fw-semibold italic">
                                    Ma Fiche Signalétique
                                </a>
                            </li>
                        @endif

                        <!-- 3. PROFIL COMMUN & DÉCONNEXION -->
                        <li class="nav-item d-flex align-items-center">
                            <a href="{{ route('profile.edit') }}" class="nav-link fw-medium text-dark">
                                {{ Auth::user()->prenom }} <span class="badge bg-light text-dark border ms-1">{{ Auth::user()->role }}</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="ms-2">
                                @csrf
                                <button type="submit" class="btn btn-link text-danger text-decoration-none btn-sm p-0">
                                    Quitter
                                </button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
       
    </nav>
</header>