@extends('layouts.app')

@section('title', 'Admin Tableau de bord')

@section('content')
    <div class="container">
        <h1>Tableau de Bord</h1>

        <!-- Section Livres -->
        <div class="row">
            <div class="col-xl-6">
                <h3>Gestion des Livres</h3>
                <a href="#" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addBookModal"><i class="bi bi-plus-circle"></i> Livre</a>
                <ul class="list-group">
                    @foreach ($books as $book)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#bookDetailsModal{{ $book->id_book }}" class="link-dark link-offset-2 link-underline link-underline-opacity-0 text-hover position-relative d-inline-block">
                                <strong>{{ $book->name_book }} </strong>
                                <i class="bi bi-eye position-absolute" style="left: 100%; margin-left: 5px; opacity: 0; transition: opacity 0.3s;"></i>
                            </a>
                            @include('admin.partials.book-details-modal', ['book' => $book])
                            <div>
                                <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editBookModal{{ $book->id_book }}"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('admin.books.delete', $book->id_book) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <!-- Pagination links -->
                <div class="mt-3">
                    {{ $books->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
            <div class="col-xl-6">
                <h3 class="mb-4">Livres Empruntés</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Titre du Livre</th>
                        <th>Utilisateur</th>
                        <th>Date d'emprunt</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($loanHistories as $loan)
                        <tr>
                            <td style="padding: 9.2px;">{{ $loan->copy->book->name_book }}</td>
                            <td style="padding: 9.2px;">{{ $loan->user->first_name_user }} {{(Str::upper($loan->user->last_name_user)) }}</td>
                            <td style="padding: 9.2px;">{{ \Carbon\Carbon::parse($loan->start_loan)->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Aucun livre emprunté actuellement.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $loanHistories->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Modals -->
    @include('admin.partials.add-book-modal')
    @foreach ($books as $book)
        @include('admin.partials.edit-book-modal', ['book' => $book])
    @endforeach

    <script>
        const textHovers = document.querySelectorAll('.text-hover');

        textHovers.forEach(textHover => {
            const icon = textHover.querySelector('i');

            textHover.addEventListener('mouseenter', () => {
                icon.style.opacity = 1; // Affiche l'icône
            });

            textHover.addEventListener('mouseleave', () => {
                icon.style.opacity = 0; // Cache l'icône
            });
        });
    </script>
@endsection
