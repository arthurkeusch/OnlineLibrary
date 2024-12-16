<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.books.add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBookModalLabel">Ajouter un Livre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name_book" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="name_book" name="name_book" required>
                    </div>
                    <div class="mb-3">
                        <label for="authors" class="form-label">Auteurs</label>
                        <select id="authors" name="authors[]" class="form-control">
                            @foreach ($authors as $author)
                                <option value="{{ $author->id_author }}"
                                    {{ $book->authors->contains($author->id_author) ? 'selected' : '' }}>
                                    {{ $author->name_author }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="categories" class="form-label">Catégories</label>
                        <select name="categories[]" id="categories" class="form-control" multiple>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id_category }}"
                                        @if (isset($book) && $book->categories->contains('id_category', $category->id_category))
                                            selected
                                    @endif>
                                    {{ $category->name_category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description_book" class="form-label">Description</label>
                        <textarea class="form-control" id="description_book" rows="3" name="description_book" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="publication_date_book" class="form-label">Date de Publication</label>
                        <input type="date" class="form-control" id="publication_date_book" name="publication_date_book" required>
                    </div>
                    <div class="mb-3">
                        <label for="image_book" class="form-label">Image du livre</label>
                        <input type="file" class="form-control" id="image_book" name="image_book" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </div>
        </form>
    </div>
</div>
