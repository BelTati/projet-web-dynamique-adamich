@extends('layouts.default')
@section('content')
<div class="container mt-5">
    <form action="{{ route('login') }}" method="POST">
        @csrf <!-- Protection CSRF obligatoire -->
        
        <div>
            <label>Email :</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label>Mot de passe :</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Se connecter</button>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif
    </form>
@endsection