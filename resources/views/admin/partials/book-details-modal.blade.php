<div class="modal fade" id="bookDetailsModal{{ $book->id_book }}" tabindex="-1" aria-labelledby="bookDetailsModalLabel{{ $book->id_book }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookDetailsModalLabel{{ $book->id_book }}">Détails du livre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column flex-md-row align-items-center">

                <div class="text-content">
                    <p><strong>Titre :</strong> {{ $book->name_book }}</p>
                    <p><strong>Auteur(s) :</strong>
                        @foreach ($book->authors as $author)
                            {{ $author->name_author }}
                        @endforeach
                    </p>
                    <p><strong>Catégorie(s) :</strong>
                        @foreach ($book->categories as $category)
                            {{ $category->name_category }}@if (!$loop->last), @endif
                        @endforeach
                    </p>
                    <p><strong>Description :</strong> {{ $book->description_book }}</p>
                    <p><strong>Date de publication :</strong> {{ $book->publication_date_book }}</p>
                </div>
                <div>
                    <img src="{{ asset('storage/books/' . $book->image_book) }}" alt="{{ $book->name_book }}" class="img-thumbnail img-fluid ml-md-3 mt-3 mt-md-0" style="max-width: 250px; height: auto;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
