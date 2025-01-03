<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;

Route::prefix('admin')->middleware(['auth', IsAdmin::class])->group(function () {
    /**
     * Affiche la page de tableau de bord pour l'administration.
     *
     * URL : /admin/dashboard
     * Méthode : GET
     * Contrôleur : AdminController
     * Fonction : dashboard
     * Nom de la route : admin.dashboard
     */
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    /**
     * Permet de se connecter en tant qu'administrateur.
     *
     * URL : /admin/auth
     * Méthode : POST
     * Contrôleur : AdminController
     * Fonction : auth
     * Nom de la route : admin.auth
     * Paramètres :
     *  - auth : string, identifiant de l'admin
     *  - password : string, mot de passe de l'admin
     */
    Route::post('/auth', [AdminController::class, 'auth'])->name('admin.auth');

    /**
     * Permet de se déconnecter en tant qu'administrateur.
     *
     * URL : /admin/logout
     * Méthode : POST
     * Contrôleur : AdminController
     * Fonction : logout
     * Nom de la route : admin.logout
     */
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    /**
     * Permet d'ajouter un livre.
     *
     * URL : /admin/books
     * Méthode : POST
     * Contrôleur : AdminController
     * Fonction : addBook
     * Nom de la route : admin.books.add
     * Paramètres :
     *  - title : string, titre du livre
     *  - author : string, auteur du livre
     *  - description : string, description du livre
     */
    Route::post('/books', [AdminController::class, 'addBook'])->name('admin.books.add');

    /**
     * Permet de modifier un livre.
     *
     * URL : /admin/books/{id}
     * Méthode : PATCH
     * Contrôleur : AdminController
     * Fonction : updateBook
     * Nom de la route : admin.books.update
     * Paramètres :
     *  - id : int, identifiant unique du livre
     *  - title : string, nouveau titre du livre (optionnel)
     *  - author : string, nouvel auteur du livre (optionnel)
     *  - description : string, nouvelle description du livre (optionnel)
     */
    Route::patch('/books/{id}', [AdminController::class, 'updateBook'])->name('admin.books.update');

    /**
     * Permet de supprimer un livre.
     *
     * URL : /admin/books/{id}
     * Méthode : DELETE
     * Contrôleur : AdminController
     * Fonction : deleteBook
     * Nom de la route : admin.books.delete
     * Paramètres :
     *  - id : int, identifiant unique du livre
     */
    Route::delete('/books/{id}', [AdminController::class, 'deleteBook'])->name('admin.books.delete');

    /**
     * Permet de supprimer un commentaire.
     *
     * URL : /admin/comments/{id}
     * Méthode : DELETE
     * Contrôleur : AdminController
     * Fonction : deleteComment
     * Nom de la route : admin.comments.delete
     * Paramètres :
     *  - id : int, identifiant unique du commentaire
     */
    Route::delete('/comments/{id}', [AdminController::class, 'deleteComment'])->name('admin.comments.delete');

    // Auteurs
    Route::get('/authors', [AdminController::class, 'authors'])->name('admin.authors');
    Route::post('/authors', [AdminController::class, 'addAuthor'])->name('admin.authors.add');
    Route::patch('/authors/{id}', [AdminController::class, 'updateAuthor'])->name('admin.authors.update');
    Route::delete('/authors/{id}', [AdminController::class, 'deleteAuthor'])->name('admin.authors.delete');

    // Catégories
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('/categories', [AdminController::class, 'addCategory'])->name('admin.categories.add');
    Route::patch('/categories/{id}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');

});
