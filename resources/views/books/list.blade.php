<!DOCTYPE html>
<html>
<head>
    <title>Liste des Livres</title>
</head>
<body>
<h1>Liste des Livres</h1>
<ul>
    @foreach ($books as $book)
        <li>
            <a href="{{ route('books.one', ['id' => $book->id_book]) }}">
                {{ $book->name_book }} -
                @foreach ($book->authors as $author)
                    {{ $author->name_author }}
                @endforeach
            </a>
        </li>
    @endforeach
</ul>
</body>
</html>
