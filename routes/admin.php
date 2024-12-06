<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    /**
     * Permet de se connecter en tant qu'administrateur.
     *
     * URL : /admin/login
     * Méthode : POST
     * Contrôleur : AdminController
     * Fonction : login
     * Nom de la route : admin.login
     * Paramètres :
     *  - login : string, identifiant de l'admin
     *  - password : string, mot de passe de l'admin
     */
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login');

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
});
