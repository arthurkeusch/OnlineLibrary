<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    Route::prefix('user')->group(function () {
        /**
         * Permet de consulter l'historique des emprunts d'un utilisateur.
         *
         * URL : /user/loanHistory
         * Méthode : GET
         * Contrôleur : UserController
         * Fonction : loanHistory
         * Nom de la route : user.loanHistory
         *
         * Description :
         * Cette route permet à un utilisateur authentifié de visualiser l'ensemble
         * de son historique d'emprunts, trié par date d'emprunt ou de retour.
         * Les emprunts en cours sont affichés en priorité.
         *
         * Middleware : auth (l'utilisateur doit être connecté pour accéder à cette route).
         */
        Route::get('/loanHistory', [UserController::class, 'loanHistory'])->name('user.loanHistory');

        /**
         * Permet de se connecter en tant qu'utilisateur.
         *
         * URL : /user/auth
         * Méthode : POST
         * Contrôleur : UserController
         * Fonction : auth
         * Nom de la route : user.auth
         * Paramètres :
         *  - auth : string, identifiant de l'utilisateur
         *  - password : string, mot de passe de l'utilisateur
         */
        Route::post('/auth', [UserController::class, 'auth'])->name('user.auth');

        /**
         * Permet de se déconnecter en tant qu'utilisateur.
         *
         * URL : /user/logout
         * Méthode : POST
         * Contrôleur : UserController
         * Fonction : logout
         * Nom de la route : user.logout
         */
        Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');

        /**
         * Permet de créer un compte utilisateur.
         *
         * URL : /user/register
         * Méthode : POST
         * Contrôleur : UserController
         * Fonction : register
         * Nom de la route : user.register
         * Paramètres :
         *  - auth : string, identifiant de l'utilisateur
         *  - password : string, mot de passe de l'utilisateur
         */
        Route::post('/register', [UserController::class, 'register'])->name('user.register');

        /**
         * Permet de modifier les informations du compte utilisateur.
         *
         * URL : /user/account
         * Méthode : PATCH
         * Contrôleur : UserController
         * Fonction : updateAccount
         * Nom de la route : user.account.update
         * Paramètres :
         *  - auth : string, nouveau auth (optionnel)
         *  - password : string, nouveau mot de passe (optionnel)
         */
        Route::patch('/account', [UserController::class, 'updateAccount'])->name('user.account.update');

        /**
         * Permet de mettre un commentaire sur un livre.
         *
         * URL : /user/reviews
         * Méthode : POST
         * Contrôleur : UserController
         * Fonction : addComment
         * Nom de la route : user.reviews.add
         * Paramètres :
         *  - book_id : int, identifiant du livre
         *  - comment : string, contenu du commentaire
         */
        Route::post('/reviews/{book_id}', [UserController::class, 'addComment'])->name('user.reviews.add');

        /**
         * Permet de supprimer un commentaire.
         *
         * URL : /user/reviews/{id}
         * Méthode : DELETE
         * Contrôleur : UserController
         * Fonction : deleteComment
         * Nom de la route : user.reviews.delete
         * Paramètres :
         *  - id_book : int, identifiant unique du livre
         *  - id_user : int, identifiant unique de l'utilisateur
         */
        Route::delete('/reviews/{id_book}/{id_user}', [UserController::class, 'deleteComment'])->name('user.reviews.delete');

        /**
         * Permet de réserver un livre.
         *
         * URL : /user/reservations
         * Méthode : POST
         * Contrôleur : UserController
         * Fonction : reserveBook
         * Nom de la route : user.reservations.add
         * Paramètres :
         *  - book_id : int, identifiant du livre
         */
        Route::post('/reservations', [UserController::class, 'reserveBook'])->name('user.reservations.add');

        /**
         * Permet de supprimer une réservation de livre.
         *
         * URL : /user/reservations/{id}
         * Méthode : DELETE
         * Contrôleur : UserController
         * Fonction : deleteReservation
         * Nom de la route : user.reservations.delete
         * Paramètres :
         *  - id : int, identifiant unique de la réservation
         */
        Route::delete('/reservations/{id}', [UserController::class, 'deleteReservation'])->name('user.reservations.delete');

        /**
         * Permet à un utilisateur de rendre un livre emprunté.
         *
         * URL : /user/returnBook/{id}
         * Méthode : POST
         * Contrôleur : UserController
         * Fonction : returnBook
         * Nom de la route : user.returnBook
         * Paramètres :
         *  - id : int, identifiant de l'historique de l'emprunt
         */
        Route::post('/returnBook/{id}', [UserController::class, 'returnBook'])->name('user.returnBook');
    });
});
