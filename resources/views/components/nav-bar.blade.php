<nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top" aria-label="Fifth navbar example">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">OnlineLibrary</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample05"
                aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample05">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="/">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/books/list">Livres</a>
                </li>
                @if(Auth::check() && !Auth::user()->isAdmin)
                    <li class="nav-item">
                        <a class="nav-link" href="/user/loanHistory">Réservations</a>
                    </li>
                @endif
                @if(Auth::check() && Auth::user()->isAdmin)
                    <li class="nav-item">
                        <a class="nav-link" href="/user/loanHistory">Réservations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/dashboard">Dashboard</a>
                    </li>
                @endif
            </ul>
            <div class="nav">
                @if(Auth::check())
                    <form action="{{ route('auth.logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline-light me-2">Se déconnecter</button>
                    </form>
                @else
                    <form action="{{ route('auth.form') }}" method="GET" style="display:inline;">
                        <button type="submit" class="btn btn-outline-light me-2">Se connecter</button>
                    </form>
                    <form action="{{ route('register.form') }}" method="GET" style="display:inline;">
                        <button type="submit" class="btn btn-warning">S'inscrire</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</nav>
