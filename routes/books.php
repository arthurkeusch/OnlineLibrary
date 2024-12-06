<?php

use App\Http\Controllers\BooksController;
use Illuminate\Support\Facades\Route;

Route::prefix('books')->group(function () {
    /**
     * Affiche la liste des livres.
     *
     * URL : /books/list
     * Méthode : GET
     * Contrôleur : BooksController
     * Fonction : list
     * Nom de la route : books.list
     */
    Route::get('/list', [BooksController::class, 'list'])->name('books.list');

    /**
     * Affiche les informations d'un livre spécifique à partir de son ID.
     *
     * URL : /books/{id}
     * Méthode : GET
     * Contrôleur : BooksController
     * Fonction : one
     * Nom de la route : books.one
     * Paramètre :
     *  - id : int, identifiant unique du livre
     */
    Route::get('/{id}', [BooksController::class, 'one'])->name('books.one');
});
