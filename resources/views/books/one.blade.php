@extends('layouts.app')

@section('title', $book->name_book)

@php
    use Illuminate\Support\Facades\Auth;

    $currentUserReview = null;
    $totalComments = $book->reviews->count();
    $canAddComment = false;

    if (Auth::check()) {
        $currentUserReview = $book->reviews->firstWhere('id_user', Auth::user()->id_user);
        $hasBorrowed = Auth::user()->hasBorrowedBook($book->id_book);
        $canAddComment = $hasBorrowed && !$currentUserReview;
    }
@endphp

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

                @if(Auth::check())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button class="btn btn-primary">
                            Emprunter ce livre
                            <span class="badge bg-light text-dark ms-2">{{ $book->copies->where('isAvailable', true)->count() }} disponibles</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <hr style="margin-top: 30px; margin-bottom: 10px;">

        <h3>Commentaires ({{ $totalComments }})</h3>

        @if($canAddComment)
            <div class="mb-4">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCommentModal">
                    Ajouter un commentaire
                </button>
            </div>
        @endif

        @if ($book->reviews->isNotEmpty())
            <div class="mt-4">
                @if($currentUserReview)
                    <div class="card mb-3" style="background-color: #f8f9fa; border-left: 4px solid #007bff;">
                        <div class="card-body position-relative">
                            <form
                                action="{{ route('user.reviews.delete', ['id_book' => $book->id_book, 'id_user' => $currentUserReview->id_user]) }}"
                                method="POST" class="position-absolute top-0 end-0 m-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                            <span class="badge bg-primary" style="user-select: none;">Votre commentaire</span>
                            <h5 class="card-title">{{ $currentUserReview->user->first_name_user }} {{ $currentUserReview->user->last_name_user }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ \Carbon\Carbon::parse($currentUserReview->date_review)->locale('fr')->translatedFormat('d F Y') }}</h6>
                            <p class="card-text">{{ $currentUserReview->content_review }}</p>
                        </div>
                    </div>
                @endif

                @foreach ($book->reviews->where('id_user', '!=', Auth::user()->id_user ?? null) as $review)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $review->user->first_name_user }} {{ $review->user->last_name_user }}</h5>
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

    <div class="modal fade" id="addCommentModal" tabindex="-1" aria-labelledby="addCommentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('user.reviews.add', ['book_id' => $book->id_book]) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCommentModalLabel">Ajouter un commentaire</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <textarea class="form-control" id="commentContent" name="comment" rows="4"
                                      required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
