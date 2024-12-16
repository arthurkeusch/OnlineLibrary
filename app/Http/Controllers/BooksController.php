<?php

namespace App\Http\Controllers;

use App\Models\Authors;
use App\Models\Books;
use App\Models\Categories;
use Illuminate\View\View;

class BooksController extends Controller
{
    /**
     * Affiche la liste des livres.
     *
     * @return View
     */
    public function list(): View
    {
        $books = Books::with(['authors', 'categories'])->get();
        $categories = Categories::all();
        $authors = Authors::all();

        return view('books.list', [
            'books' => $books,
            'categories' => $categories,
            'authors' => $authors
        ]);
    }

    /**
     * Affiche les informations d'un livre spécifique à partir de son ID.
     *
     * @param int $id
     * @return View
     */
    public function one(int $id): View
    {
        $book = Books::with(['authors', 'copies', 'reviews.user'])->findOrFail($id);

        return view('books.one', ['book' => $book]);
    }
}
