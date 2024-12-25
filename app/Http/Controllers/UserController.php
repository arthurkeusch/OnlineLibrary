<?php

namespace App\Http\Controllers;

use App\Models\LoanHistory;
use App\Models\Reviews;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): View|Factory|Application
    {
        return view('user.dashboard');
    }

    /**
     * Supprime un commentaire.
     *
     * @param int $id_book L'identifiant unique du livre
     * @param int $id_user L'identifiant unique de l'utilisateur
     * @return RedirectResponse
     */
    public function deleteComment(int $id_book, int $id_user): RedirectResponse
    {
        $review = Reviews::where('id_book', $id_book)
            ->where('id_user', $id_user)
            ->first();

        if (!$review) {
            return redirect()->back()->withErrors(['error' => 'Commentaire introuvable.']);
        }

        if ($id_user !== (int)auth()->user()->id_user) {
            return redirect()->back()->withErrors(['error' => 'Vous n\'êtes pas autorisé à supprimer ce commentaire.']);
        }

        Reviews::where('id_book', $id_book)
            ->where('id_user', $id_user)
            ->delete();

        return redirect()->back()->with('success', 'Commentaire supprimé avec succès.');
    }

    /**
     * Ajoute un commentaire à un livre.
     *
     * @param Request $request
     * @param int $book_id L'identifiant du livre
     * @return RedirectResponse
     */

    public function addComment(Request $request, int $book_id): RedirectResponse
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'Vous devez être connecté pour ajouter un commentaire.']);
        }

        $validatedData = $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $hasBorrowed = LoanHistory::where('id_user', $user->id_user)
            ->whereHas('copy', function ($query) use ($book_id) {
                $query->where('id_book', $book_id);
            })
            ->exists();

        if (!$hasBorrowed) {
            return redirect()->back()->withErrors(['error' => 'Vous devez avoir emprunté ce livre pour ajouter un commentaire.']);
        }

        $review = Reviews::where('id_book', $book_id)
            ->where('id_user', $user->id_user)
            ->first();

        if ($review) {
            $review->update([
                'content_review' => $validatedData['comment'],
                'date_review' => now(),
            ]);
        } else {
            Reviews::create([
                'id_book' => $book_id,
                'id_user' => $user->id_user,
                'content_review' => $validatedData['comment'],
                'date_review' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Votre commentaire a été ajouté avec succès.');
    }
}
