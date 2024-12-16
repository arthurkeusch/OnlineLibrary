<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.form');
Route::post('/login', [AuthController::class, 'login'])->name('auth');

// Inclure les autres fichiers de routes
require __DIR__ . '/books.php';
require __DIR__ . '/user.php';
require __DIR__ . '/admin.php';
