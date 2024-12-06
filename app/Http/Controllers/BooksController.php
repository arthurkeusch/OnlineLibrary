<?php

namespace App\Http\Controllers;

use App\Models\Books;
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
        // Récupère tous les livres avec leurs auteurs depuis la base de données
        $books = Books::with('authors')->get();

        // Retourne la vue avec les données
        return view('books.list', ['books' => $books]);
    }

    /**
     * Affiche les informations d'un livre spécifique à partir de son ID.
     *
     * @param int $id
     * @return View
     */
    public function one(int $id): View
    {
        // Récupère le livre avec ses auteurs à partir de son ID
        $book = Books::with('authors')->findOrFail($id);

        // Retourne la vue avec les données
        return view('books.one', ['book' => $book]);
    }
}
