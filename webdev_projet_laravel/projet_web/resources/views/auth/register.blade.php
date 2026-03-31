@extends('layouts.default')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">S'inscrire (Étape 1/2)</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        <!-- Nom & Prénom -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required autofocus>
                                @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prénom</label>
                                <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" required>
                                @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Adresse Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Choix du Rôle (Différenciation) -->
                        <div class="mb-4">
                            <label class="form-label d-block">Vous souhaitez vous inscrire en tant que :</label>
                            
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('role') is-invalid @enderror" type="radio" name="role" id="role_user" value="USER" {{ old('role', 'USER') == 'USER' ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_user">
                                    <i class="bi bi-person"></i> Internaute
                                </label>
                            </div>
                            
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('role') is-invalid @enderror" type="radio" name="role" id="role_provider" value="PROVIDER" {{ old('role') == 'PROVIDER' ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_provider">
                                    <i class="bi bi-briefcase"></i> Prestataire
                                </label>
                            </div>
                            
                            @error('role') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Envoyer le lien de confirmation
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <p class="mb-0 text-muted">Déjà un compte ? <a href="{{ route('login') }}">Connectez-vous</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection