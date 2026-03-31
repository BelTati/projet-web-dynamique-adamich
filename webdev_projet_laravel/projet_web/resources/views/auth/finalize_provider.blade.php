@extends('layouts.default')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Fiche Signalétique Prestataire</h4>
                </div>
                <div class="card-body p-4">
                   @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                <form action="{{ route('confirm.finalize', $user->inscription_confirmation_token) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Identité -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nom de l'entreprise / Nom</label>
                                <input type="text" name="nom" class="form-control" value="{{ old('nom', $user->nom) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Prénom du contact</label>
                                <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $user->prenom) }}" required>
                            </div>
                        </div>

                        <!-- Infos Professionnelles -->
                        <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">Informations Professionnelles</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Numéro de TVA</label>
                                <input type="text" name="tva" class="form-control @error('tva') is-invalid @enderror" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">GSM / Mobile</label>
                                <input type="text" name="telephone_mobile" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Site Web officiel</label>
                            <input type="url" name="site_web" class="form-control" placeholder="https://www.monsite.be">
                        </div>
                      

                        <!-- Adresse Physique -->
                        <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">Adresse physique</h5>
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <label class="form-label">Rue</label>
                                <input type="text" name="rue" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">N°</label>
                                <input type="text" name="numéro" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                                <label class="form-label">Boîte</label>
                                <input type="text" name="boîte" class="form-control" value="{{ old('boîte') }}">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Code Postal</label>
                                <input type="text" name="cp" class="form-control" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Ville</label>
                                <input type="text" name="ville" class="form-control" required>
                            </div>
                             <div class="col-md-4">
                                <label class="form-label">Pays</label>
                                <input type="text" name="pays" class="form-control" value="Belgique" required>
                            </div>        
                        </div>

                        <!-- Sécurité -->
                        <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">Sécurité</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Mot de passe final</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirmation</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Finaliser mon compte Prestataire</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

