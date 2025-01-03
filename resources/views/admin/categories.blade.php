@extends('layouts.app')

@section('title', 'Gestion des Catégories')

@section('content')
    <div class="container">
        <h1>Gestion des Catégories</h1>

        <!-- Affichage des messages de succès ou d'erreur -->
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-end">
            <h2 class="mt-4">Liste des Catégories</h2>
            <a href="#" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal"><i class="bi bi-plus-circle"></i> Ajouter une catégorie</a> </div>
        <ul class="list-group">
            @foreach ($categories as $category)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $category->name_category }}
                    <div>
                        <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id_category }}"><i class="bi bi-pencil-square"></i>  Modifier</a>

                        <form action="{{ route('admin.categories.delete', $category->id_category) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash3"></i> Supprimer</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="mt-3">
            {{ $categories->links('vendor.pagination.bootstrap-5') }}
        </div>

        <!-- Modal Ajouter Catégorie -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Ajouter une Catégorie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.categories.add') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name_category">Nom de la Catégorie</label>
                                <input type="text" name="name_category" id="name_category" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-success">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Modifier Catégorie -->
        @foreach($categories as $category)
        <div class="modal fade" id="editCategoryModal{{ $category->id_category }}" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $category->id_category }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id_category }}">Modifier la Catégorie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.categories.update', $category->id_category) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name_category">Nom de la Catégorie</label>
                                <input type="text" name="name_category" id="name_category" class="form-control" value="{{ $category->name_category }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
