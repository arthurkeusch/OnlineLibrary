@php use Carbon\Carbon; @endphp

@extends('layouts.app')

@section('title', 'Bienvenue sur OnlineLibrary')

@section('content')
    <div class="container text-center mt-5">
        <h1 class="display-4">Bienvenue sur OnlineLibrary</h1>
        <p class="lead">Votre bibliothèque numérique pour explorer, découvrir et emprunter vos livres préférés.</p>
        <hr class="my-4">

        <div class="mt-4">
            <a href="/books/list" class="btn btn-primary btn-lg mx-2">Explorer les livres</a>
            <a href="/register" class="btn btn-success btn-lg mx-2">Créer un compte</a>
            <a href="/login" class="btn btn-outline-secondary btn-lg mx-2">Se connecter</a>
        </div>
    </div>

    <div class="container mt-5">
        <h2 class="text-center">Livres les plus réservés</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-3">
            @foreach ($featuredBooks as $book)
                <a href="/books/{{ $book->id_book }}" class="text-decoration-none">
                    <div class="col">
                        <div class="card shadow-sm h-100" style="cursor: pointer;">
                            <img
                                src="{{ $book->image_book ? asset($book->image_book) : asset('storage/books/book.jpg') }}"
                                class="card-img-top" alt="Image du livre : {{ $book->name_book }}">
                            <div class="card-body">
                                <h5 class="card-title" style="text-align: center;">
                                    {{ $book->name_book }}<br>
                                    <sub>({{ Carbon::parse($book->publication_date_book)->year }})</sub>
                                </h5>
                                <p class="card-text text-muted">
                                    @foreach ($book->authors as $author)
                                        {{ $author->name_author }}
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
