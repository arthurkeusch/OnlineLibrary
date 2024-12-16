<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\IsAdmin;

Route::get('/', [HomeController::class, 'index'])->name('home');

use App\Http\Controllers\AuthController;

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.form');
Route::post('/login', [AuthController::class, 'login'])->name('auth');

// Routes protégées par le middleware auth
Route::middleware(['auth'])->group(function () {
    // Route pour le tableau de bord utilisateur
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');

    // Routes pour le tableau de bord administrateur
    Route::middleware([IsAdmin::class])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });
});

// Inclure les autres fichiers de routes
require __DIR__ . '/books.php';
require __DIR__ . '/user.php';
require __DIR__ . '/admin.php';
