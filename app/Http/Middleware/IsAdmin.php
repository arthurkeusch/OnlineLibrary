<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Gère une requête entrante.
     *
     * Ce middleware vérifie si l'utilisateur connecté est administrateur.
     * Si ce n'est pas le cas, il est redirigé vers le tableau de bord administrateur.
     * Sinon, la requête est transmise au middleware suivant.
     *
     * @param Closure(Request): (Response) $next La fonction suivante dans la chaîne des middlewares
     * @param Request $request La requête entrante
     * @return Response La réponse HTTP
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && !Auth::user()->isAdmin) {
            return redirect()->route('admin.dashboard');
        }
        return $next($request);
    }
}
