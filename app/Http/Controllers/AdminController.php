<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Authors;
use App\Models\Categories;
use App\Models\LoanHistory;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $books = Books::orderBy('name_book', 'asc')
            ->paginate(10, ['*'], 'booksPage')
            ->appends($request->except('booksPage'));

        $authors = Authors::all();
        $categories = Categories::all();

        $loanHistories = LoanHistory::with(['copy.book', 'user'])
            ->orderBy('start_loan', 'desc')
            ->get();

        return view('admin.dashboard', compact('books', 'authors', 'categories', 'loanHistories'));
    }

    public function addBook(Request $request)
    {
        $validated = $request->validate([
            'name_book' => 'required|string|max:255',
            'description_book' => 'nullable|string',
            'publication_date_book' => 'nullable|date',
            'image_book' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validation de l'image
            'authors' => 'nullable|array',
            'authors.*' => 'exists:authors,id_author',
            'categories' => 'nullable|array',  // Validation pour les catégories
            'categories.*' => 'exists:categories,id_category',
        ]);

        // Gérer le téléchargement de l'image si présent
        $imageName = null;
        if ($request->hasFile('image_book')) {
            $file = $request->file('image_book');
            $imageName = $file->getClientOriginalName();
            $file->storeAs('books', $imageName, 'public');
        }

        // Créer le livre
        $book = Books::create([
            'name_book' => $validated['name_book'],
            'description_book' => $validated['description_book'],
            'publication_date_book' => $validated['publication_date_book'],
            'image_book' => $imageName,
        ]);

        // Attacher les auteurs sélectionnés
        if (isset($validated['authors'])) {
            $book->authors()->attach($validated['authors']);
        }

        // Attacher les catégories sélectionnées
        if (isset($validated['categories'])) {
            $book->categories()->attach($validated['categories']);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Livre ajouté avec succès');
    }

    public function updateBook(Request $request, $id)
    {
        $validated = $request->validate([
            'name_book' => 'required|string|max:255',
            'description_book' => 'nullable|string',
            'publication_date_book' => 'nullable|date',
            'image_book' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validation de l'image
            'authors' => 'nullable|array',
            'authors.*' => 'exists:authors,id_author',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id_category',
        ]);

        $book = Books::findOrFail($id);

        $imageName = $book->image_book; // Garder l'ancien nom de l'image
        if ($request->hasFile('image_book')) {
            $file = $request->file('image_book');
            $imageName = $file->getClientOriginalName();

            // Supprimer l'ancienne image si elle existe
            if ($book->image_book && file_exists(storage_path('app/public/books/' . $book->image_book))) {
                unlink(storage_path('app/public/books/' . $book->image_book));
            }

            $file->storeAs('books', $imageName, 'public');
        }

        // Mettre à jour le livre
        $book->update([
            'name_book' => $validated['name_book'],
            'description_book' => $validated['description_book'],
            'publication_date_book' => $validated['publication_date_book'],
            'image_book' => $imageName, // Mettre à jour le nom de l'image
        ]);

        if (isset($validated['authors'])) {
            $book->authors()->sync($validated['authors']);
        } else {
            $book->authors()->detach(); // Supprimer tous les auteurs si aucun n'est sélectionné
        }

        if (isset($validated['categories'])) {
            $book->authors()->sync($validated['categories']);
        } else {
            $book->authors()->detach(); // Supprimer tous les auteurs si aucun n'est sélectionné
        }

        return redirect()->route('admin.dashboard')->with('success', 'Livre modifié avec succès');
    }

    public function deleteBook($id)
    {
        $book = Books::findOrFail($id);

        // Supprimer les relations
        $book->categories()->detach();
        $book->authors()->detach();

        // Vérifier et supprimer l'image associée si elle existe
        if ($book->image_book && file_exists(storage_path('app/public/books/' . $book->image_book))) {
            unlink(storage_path('app/public/books/' . $book->image_book));
        }

        // Supprimer le livre
        $book->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Livre supprimé avec succès');
    }

    public function authors()
    {
        $authors = Authors::orderBy('name_author', 'asc')
            ->paginate(10, ['*'], 'authorsPage');

        return view('admin.authors', compact('authors'));
    }

    public function addAuthor(Request $request)
    {
        $request->validate(['name_author' => 'required|string|max:255']);
        Authors::create($request->only('name_author'));
        return redirect()->route('admin.authors')->with('success', 'Auteur ajouté avec succès.');
    }

    public function updateAuthor(Request $request, $id)
    {
        $request->validate(['name_author' => 'required|string|max:255']);
        $author = Authors::findOrFail($id);
        $author->update($request->only('name_author'));
        return redirect()->route('admin.authors')->with('success', 'Auteur modifié avec succès.');
    }

    public function deleteAuthor($id)
    {
        $author = Authors::find($id);

        if (!$author) {
            return redirect()->back()->with('error', 'Auteur non trouvé.');
        }

        if ($author->hasBooks()) {
            return redirect()->back()->with('error', 'L\'auteur ne peut pas être supprimé car il est associé à des livres.');
        }

        $author->delete();

        return redirect()->route('admin.authors')->with('success', 'Auteur supprimé avec succès.');
    }

    public function categories(Request $request)
    {
        $categories = Categories::orderBy('name_category', 'asc')
            ->paginate(10, ['*'], 'authorsPage');

        return view('admin.categories', compact('categories'));
    }

    public function addCategory(Request $request)
    {
        $request->validate([
            'name_category' => 'required|string|max:255',
        ]);

        Categories::create($request->all());

        return redirect()->route('admin.categories')->with('success', 'Catégorie ajoutée avec succès.');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Categories::find($id);
        if (!$category) {
            return redirect()->route('admin.categories')->with('error', 'Catégorie non trouvée.');
        }

        $request->validate([
            'name_category' => 'required|string|max:255',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories')->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function deleteCategory($id)
    {
        $category = Categories::find($id);

        if (!$category) {
            return redirect()->route('admin.categories')->with('error', 'Catégorie non trouvée.');
        }

        if ($category->books()->exists()) {
            return redirect()->route('admin.categories')->with('error', 'Impossible de supprimer cette catégorie car elle est associée à un ou plusieurs livres.');
        }

        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Catégorie supprimée avec succès.');
    }
}
