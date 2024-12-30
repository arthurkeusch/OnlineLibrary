<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion.
     *
     * @return View
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Affiche le formulaire d'inscription.
     *
     * @return View
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Gère la tentative d'inscription de l'utilisateur.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|unique:Users,username', // Unique dans la table 'Users'
            'password' => 'required|string|confirmed', // Le champ 'password_confirmation' doit correspondre
            'first_name_user' => 'required|string',
            'last_name_user' => 'required|string',
        ]);

        $user = Users::create([
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']), // Hacher le mot de passe
            'first_name_user' => $validatedData['first_name_user'],
            'last_name_user' => $validatedData['last_name_user'],
            'isAdmin' => false, // Par défaut, un nouvel utilisateur n'est pas administrateur
        ]);
        Auth::login($user);
        return redirect()->route('home')->with('success', 'Votre compte a été créé avec succès.');
    }

    /**
     * Gère la tentative de connexion de l'utilisateur.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['username' => $credentials['login'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('home');
            }
        }

        return back()->withErrors([
            'login' => 'Les identifiants sont incorrects.',
        ]);
    }

    /**
     * Déconnecte l'utilisateur authentifié.
     *
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/')->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
