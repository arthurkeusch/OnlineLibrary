@extends('layouts.app')

@section('title', $book->name_book)

@section('content')
    <div class="container mt-5">
        <h1 class="text-center">{{ $book->name_book }}</h1>
        <div class="row mt-4">
            <div class="col-md-4 text-center">
                <img
                    src="{{ $book->image_book ? asset('storage/books/' . $book->image_book) : asset('storage/books/book.jpg') }}"
                    alt="Image du livre : {{ $book->name_book }}"
                    class="img-fluid"
                    style="max-height: 300px;">
            </div>
            <div class="col-md-8">
                <p><strong>Auteurs :</strong>
                    @foreach ($book->authors as $author)
                        {{ $author->name_author }}{{ !$loop->last ? ', ' : '' }}
                    @endforeach
                </p>
                <p><strong>Description :</strong> {{ $book->description_book }}</p>
                <p><strong>Date de publication
                        :</strong> {{ \Carbon\Carbon::parse($book->publication_date_book)->locale('fr')->translatedFormat('d F Y') }}
                </p>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <button class="btn btn-primary">
                        Emprunter ce livre
                        <span class="badge bg-light text-dark ms-2">{{ $book->copies->where('isAvailable', true)->count() }} disponibles</span>
                    </button>
                </div>
            </div>
        </div>

        <hr class="my-5">

        <h3>Commentaires</h3>
        @if ($book->reviews->isNotEmpty())
            <div class="mt-4">
                @foreach ($book->reviews as $review)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $review->user->username }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ \Carbon\Carbon::parse($review->date_review)->locale('fr')->translatedFormat('d F Y') }}</h6>
                            <p class="card-text">{{ $review->content_review }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">Aucun commentaire pour ce livre.</p>
        @endif
    </div>
@endsection
