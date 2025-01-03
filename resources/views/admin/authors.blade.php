@extends('layouts.app')

@section('title', 'Gestion des Auteurs')

@section('content')
    <div class="container">
        <h1>Gestion des Auteurs</h1>
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Liste des auteurs -->
        <div class="d-flex justify-content-between align-items-end">
            <h2 class="mt-4">Liste des Auteurs</h2>
            <a href="#" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addAuthorModal"><i class="bi bi-plus-circle"></i> Auteur</a>
        </div>
        <ul class="list-group">
            @foreach ($authors as $author)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $author->name_author }}
                    <div>
                        <!-- Modifier -->
                        <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editAuthorModal{{ $author->id_author }}"><i class="bi bi-pencil-square"></i> Modifier</a>

                        <!-- Supprimer -->
                        <form action="{{ route('admin.authors.delete', $author->id_author) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash3"></i> Supprimer</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="mt-3">
            {{ $authors->links('vendor.pagination.bootstrap-5') }}
        </div>

        <!-- Modal d'ajout d'auteur -->
        <div class="modal fade" id="addAuthorModal" tabindex="-1" aria-labelledby="addAuthorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAuthorModalLabel">Ajouter un Auteur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.authors.add') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="authorName" class="form-label">Nom de l'Auteur</label>
                                <input type="text" class="form-control" id="name_author" name="name_author" required>
                            </div>
                            <button type="submit" class="btn btn-success">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de modification d'auteur -->
        @foreach ($authors as $author)
            <div class="modal fade" id="editAuthorModal{{ $author->id_author }}" tabindex="-1" aria-labelledby="editAuthorModalLabel{{ $author->id_author }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editAuthorModalLabel{{ $author->id_author }}">Modifier l'Auteur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.authors.update', $author->id_author) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="authorName" class="form-label">Nom de l'Auteur</label>
                                    <input type="text" class="form-control" id="name_author" name="name_author" value="{{ $author->name_author }}" required>
                                </div>
                                <button type="submit" class="btn btn-warning">Modifier</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
