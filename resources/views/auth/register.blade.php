@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="height: 80vh;">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
            <h3 class="text-center mb-4">Créer un compte</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required>
                </div>
                <div class="mb-3">
                    <label for="first_name_user" class="form-label">Prénom</label>
                    <input type="text" id="first_name_user" name="first_name_user" class="form-control" value="{{ old('first_name_user') }}" required>
                </div>
                <div class="mb-3">
                    <label for="last_name_user" class="form-label">Nom</label>
                    <input type="text" id="last_name_user" name="last_name_user" class="form-control" value="{{ old('last_name_user') }}" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
            </form>
        </div>
    </div>
@endsection
