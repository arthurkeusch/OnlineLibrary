<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.form');
Route::post('/login', [AuthController::class, 'login'])->name('auth');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

require __DIR__ . '/books.php';
require __DIR__ . '/user.php';
require __DIR__ . '/admin.php';
