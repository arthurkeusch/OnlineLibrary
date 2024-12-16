<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Models\Users;
use App\Http\Middleware\IsAdmin;

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

            if (Auth::user()->isAdmin) {
                // Rediriger l'administrateur vers le tableau de bord admin
                return redirect()->route('admin.dashboard');
            } else {
                // Rediriger l'utilisateur non admin vers la page d'accueil
                return redirect()->route('home');
            }
        }

        // En cas d'échec, retourner une erreur
        return back()->withErrors([
            'login' => 'Les identifiants sont incorrects.',
        ]);
    }

}
