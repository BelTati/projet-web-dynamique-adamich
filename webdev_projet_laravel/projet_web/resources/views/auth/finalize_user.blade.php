@extends('layouts.default')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Finaliser votre inscription Internaute</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('confirm.finalize', $user->inscription_confirmation_token) }}" method="POST">
                        @csrf
                        
                        <!-- Identité (Rappel de l'étape 1) -->
                        <h5 class="text-success border-bottom pb-2 mb-3">Votre Identité</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" class="form-control" value="{{ old('nom', $user->nom) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Prénom</label>
                                <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $user->prenom) }}" required>
                            </div>
                        </div>

                        <!-- Adresse -->
                        <h5 class="text-success border-bottom pb-2 mb-3 mt-4">Adresse de courrier</h5>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Rue</label>
                                <input type="text" name="rue" class="form-control @error('rue') is-invalid @enderror" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">N°</label>
                                <input type="text" name="numéro" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Boîte</label>
                                <input type="text" name="boîte" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Code Postal</label>
                                <input type="text" name="cp" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Ville</label>
                                <input type="text" name="ville" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pays</label>
                                <input type="text" name="pays" class="form-control" value="Belgique" required>
                            </div>
                        </div>

                        <!-- Sécurité -->
                        <h5 class="text-success border-bottom pb-2 mb-3 mt-4">Sécurité</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirmer le mot de passe</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success btn-lg">Activer mon compte Internaute</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
