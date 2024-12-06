<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil.
     *
     * @return View
     */
    public function index(): View
    {
        $featuredBooks = Books::with('authors')
            ->select('Books.*')
            ->leftJoin('Copies', 'Books.id_book', '=', 'Copies.id_book')
            ->leftJoin('LoanHistory', 'Copies.id_copy', '=', 'LoanHistory.id_copy')
            ->selectRaw('COUNT(LoanHistory.id_user) as reservations_count')
            ->groupBy('Books.id_book')
            ->orderByDesc('reservations_count')
            ->take(6)
            ->get();

        return view('welcome', [
            'featuredBooks' => $featuredBooks,
        ]);
    }
}
