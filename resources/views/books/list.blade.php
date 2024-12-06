@php
    use Carbon\Carbon;
    $categories = $categories ?? collect();
    $authors = $authors ?? collect();
    $totalCategories = $categories->count();
    $categoriesColumns = min(ceil($totalCategories / 10), 3);
    $categoriesPerColumn = ceil($totalCategories / $categoriesColumns);
    $totalAuthors = $authors->count();
    $authorsColumns = min(ceil($totalAuthors / 5), 5);
    $authorsPerColumn = ceil($totalAuthors / $authorsColumns);
@endphp

@extends('layouts.app')

@section('title', 'Liste des livres')

@section('content')
    <div style="margin: 10px 20%;">
        <input type="text" id="searchBar" class="form-control" placeholder="Rechercher un livre par nom"
               onkeyup="filterBooks()">
    </div>

    <div class="row mt-3" style="margin: 0 5%;">
        <div class="col-md" style="flex: {{ max($totalCategories / ($totalCategories + $totalAuthors), 0.3) }};">
            <h5>Catégories</h5>
            <div class="row row-cols-{{ $categoriesColumns }}">
                @foreach ($categories->chunk($categoriesPerColumn) as $chunkedCategories)
                    <div class="col">
                        @foreach ($chunkedCategories as $category)
                            <div class="form-check">
                                <input class="form-check-input category-checkbox" type="checkbox"
                                       value="{{ $category->name_category }}" id="category-{{ $category->id_category }}"
                                       onchange="filterBooks()" style="user-select: none; cursor: pointer;">
                                <label class="form-check-label" for="category-{{ $category->id_category }}"
                                       style="user-select: none; cursor: pointer;">
                                    {{ $category->name_category }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md" style="flex: {{ max($totalAuthors / ($totalCategories + $totalAuthors), 0.3) }};">
            <h5>Auteurs</h5>
            <div class="row row-cols-{{ $authorsColumns }}">
                @foreach ($authors->chunk($authorsPerColumn) as $chunkedAuthors)
                    <div class="col">
                        @foreach ($chunkedAuthors as $author)
                            <div class="form-check">
                                <input class="form-check-input author-checkbox" type="checkbox"
                                       value="{{ $author->name_author }}" id="author-{{ $author->id_author }}"
                                       onchange="filterBooks()" style="user-select: none; cursor: pointer;">
                                <label class="form-check-label" for="author-{{ $author->id_author }}"
                                       style="user-select: none; cursor: pointer;">
                                    {{ $author->name_author }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-primary" onclick="resetFilters()">Réinitialiser les filtres</button>
        <p class="mt-2">Livres : <span id="visibleBooksCount">{{ $books->count() }}</span></p>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 g-4 mt-4" id="booksContainer">
        @foreach ($books as $book)
            <div class="col book-item" data-categories="{{ $book->categories->pluck('name_category')->implode(',') }}"
                 data-authors="{{ $book->authors->pluck('name_author')->implode(',') }}">
                <a href="/books/{{ $book->id_book }}" class="text-decoration-none">
                    <div class="card shadow-sm h-100" style="cursor: pointer;">
                        <img src="{{ $book->image_book ? asset($book->image_book) : asset('storage/books/book.jpg') }}"
                             class="card-img-top"
                             alt="Image du livre : {{ $book->name_book }}">
                        <div class="card-body">
                            <h5 class="card-title book-name" style="text-align: center;">
                                {{ $book->name_book }}<br><sub>({{ Carbon::parse($book->publication_date_book)->year }}
                                    )</sub>
                            </h5>
                            <p class="card-text text-muted">
                                @foreach ($book->authors as $author)
                                    {{ $author->name_author }}
                                @endforeach
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>



    <script>
        function filterBooks() {
            const selectedCategories = Array.from(document.querySelectorAll('.category-checkbox:checked')).map(checkbox => checkbox.value.toLowerCase());

            const selectedAuthors = Array.from(document.querySelectorAll('.author-checkbox:checked')).map(checkbox => checkbox.value.toLowerCase());
            let visibleCount = 0;

            document.querySelectorAll('.book-item').forEach(book => {
                const bookName = book.querySelector('.book-name').textContent.toLowerCase();
                const bookCategories = book.getAttribute('data-categories').toLowerCase().split(',');
                const bookAuthors = book.getAttribute('data-authors').toLowerCase().split(',');

                const matchesSearch = bookName.includes(document.getElementById('searchBar').value.toLowerCase());
                const matchesCategory = selectedCategories.length === 0 || selectedCategories.some(category => bookCategories.includes(category));
                const matchesAuthor = selectedAuthors.length === 0 || selectedAuthors.some(author => bookAuthors.includes(author));

                if (matchesSearch && matchesCategory && matchesAuthor) {
                    book.style.display = '';
                    visibleCount++;
                } else {
                    book.style.display = 'none';
                }
            });

            document.getElementById('visibleBooksCount').textContent = visibleCount;
        }

        function resetFilters() {
            document.getElementById('searchBar').value = '';
            document.querySelectorAll('.category-checkbox').forEach(checkbox => checkbox.checked = false);
            document.querySelectorAll('.author-checkbox').forEach(checkbox => checkbox.checked = false);
            filterBooks();
        }
    </script>
@endsection
