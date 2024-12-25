<?php

namespace App\Http\Controllers;

use App\Models\Copies;
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

    /**
     * Permet à un utilisateur d'emprunter un livre.
     *
     * Vérifie si l'utilisateur est connecté, valide les paramètres de la requête et s'assure que l'exemplaire est disponible.
     * Si toutes les conditions sont remplies, l'emprunt est enregistré et la disponibilité de l'exemplaire est mise à jour.
     *
     * @param Request $request La requête contenant les identifiants du livre et de l'exemplaire.
     * @return RedirectResponse La réponse de redirection avec un message de succès ou d'erreur.
     */
    public function reserveBook(Request $request): RedirectResponse
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'Vous devez être connecté pour emprunter un livre.']);
        }

        $request->validate([
            'book_id' => 'required|integer',
            'copy_id' => 'required|integer',
        ]);

        $copy = Copies::find($request->input('copy_id'));

        if (!$copy || !$copy->isAvailable || $copy->id_book != $request->input('book_id')) {
            return redirect()->back()->withErrors(['error' => 'Cet exemplaire n\'est pas disponible ou n\'appartient pas à ce livre.']);
        }

        LoanHistory::create([
            'id_copy' => $copy->id_copy,
            'id_user' => $user->id_user,
            'start_loan' => now(),
            'end_loan' => null,
        ]);

        $copy->update(['isAvailable' => false]);

        return redirect()->back()->with('success', 'Vous avez emprunté cet exemplaire avec succès.');
    }

    /**
     * Affiche l'historique des emprunts de l'utilisateur connecté.
     *
     * Cette méthode permet à un utilisateur authentifié de consulter la liste des livres
     * qu'il a empruntés. Les emprunts non rendus sont affichés en premier, suivis des emprunts rendus,
     * triés par date de rendu de la plus récente à la plus ancienne.
     *
     * @return View|Factory|Application La vue affichant l'historique des emprunts.
     */
    public function loanHistory(): View|Factory|Application
    {
        $user = auth()->user();
        $loanedBooks = LoanHistory::where('id_user', $user->id_user)
            ->with(['copy.book'])
            ->orderByRaw('end_loan IS NULL DESC')
            ->orderByDesc('end_loan')
            ->get();

        return view('user.loanHistory', compact('loanedBooks'));
    }

    /**
     * Permet à un utilisateur de rendre un livre emprunté.
     *
     * Cette méthode met à jour l'exemplaire pour qu'il soit de nouveau disponible
     * et enregistre la date de retour dans l'historique de l'emprunt.
     *
     * @param int $id_loanhistory L'identifiant de l'historique de l'emprunt.
     * @return RedirectResponse
     */
    public function returnBook(int $id_loanhistory): RedirectResponse
    {
        $loan = LoanHistory::findOrFail($id_loanhistory);

        if ($loan->end_loan !== null) {
            return redirect()->back()->withErrors(['error' => 'Ce livre a déjà été rendu.']);
        }

        $loan->copy->update(['isAvailable' => true]);

        $loan->update(['end_loan' => now()]);

        return redirect()->back()->with('success', 'Livre rendu avec succès.');
    }
}
