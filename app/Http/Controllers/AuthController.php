<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Valider les données d'entrée
        $credentials = $request->validate([
            'login' => 'required|string', // Utiliser "login" comme identifiant
            'password' => 'required|string',
        ]);

        // Tenter de connecter l'utilisateur avec "login" comme champ
        if (Auth::attempt(['username' => $credentials['login'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            // Rediriger selon le rôle de l'utilisateur
            return redirect()->intended(Auth::user()->isAdmin ? '/admin/dashboard' : '/dashboard');
        }

        // En cas d'échec, retourner une erreur
        return back()->withErrors([
            'login' => 'Les identifiants sont incorrects.',
        ]);
    }
}
