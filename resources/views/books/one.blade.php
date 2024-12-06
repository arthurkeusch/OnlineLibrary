<!DOCTYPE html>
<html>
<head>
    <title>{{ $book->name_book }}</title>
</head>
<body>
<h1>{{ $book->name_book }}</h1>
<p><strong>Auteurs :</strong>
    @foreach ($book->authors as $author)
        {{ $author->name_author }}
    @endforeach
</p>
<p><strong>Description :</strong> {{ $book->description_book }}</p>
<p><strong>Date de publication :</strong> {{ $book->publication_date_book }}</p>
<a href="{{ route('books.list') }}">Retour à la liste des livres</a>
</body>
</html>
