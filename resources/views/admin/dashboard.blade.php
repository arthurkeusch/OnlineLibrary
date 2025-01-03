@extends('layouts.app')

@section('title', 'Admin Tableau de bord')

@section('content')
    <div class="container">
        <h1>Tableau de Bord</h1>

        <!-- Section Livres -->
        <div class="row">
            <div class="col-xl-5">
                <h3>Gestion des Livres</h3>
                <a href="#" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addBookModal"><i class="bi bi-plus-circle"></i> Livre</a>
                <a href="{{ route('admin.authors') }}" class="btn btn-primary mb-3">
                    <i class="bi bi-person"></i> Gérer les Auteurs
                </a>
                <a href="{{ route('admin.categories') }}" class="btn btn-warning mb-3">
                    <i class="bi bi-tags"></i> Gérer les Catégories
                </a>
                <ul class="list-group">
                    @foreach ($books as $book)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#bookDetailsModal{{ $book->id_book }}" class="link-dark link-offset-2 link-underline link-underline-opacity-0 text-hover position-relative d-inline-block">
                                <strong>{{ $book->name_book }} </strong>
                                <i class="bi bi-eye position-absolute" style="left: 100%; margin-left: 5px; opacity: 0; transition: opacity 0.3s;"></i>
                            </a>
                            @include('admin.partials.book-details-modal', ['book' => $book])
                            <div>
                                <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editBookModal{{ $book->id_book }}"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('admin.books.delete', $book->id_book) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-3">
                    {{ $books->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>

            <div class="col-xl-7">
                <h3>Livres Empruntés</h3>
                <div class="mb-3">
                    <button class="btn btn-primary filter-btn" data-filter="all" id="filterAllBtn">Tous</button>
                    <button class="btn btn-outline-success filter-btn" data-filter="not-returned" id="filterNotReturnedBtn">Non rendus</button>
                    <button class="btn btn-outline-danger filter-btn" data-filter="overdue" id="filterOverdueBtn">En retard (+2 mois)</button>
                </div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th data-sort-key="title" style="cursor:pointer">Titre du Livre</th>
                        <th data-sort-key="user" style="cursor:pointer">Utilisateur</th>
                        <th data-sort-key="start_loan" style="cursor:pointer">Date d'emprunt</th>
                        <th data-sort-key="end_loan" style="cursor:pointer">Date de retour</th>
                    </tr>
                    </thead>
                    <tbody id="loanTableBody">
                    <!-- Les lignes du tableau seront générées par JavaScript -->
                    </tbody>
                </table>
                <div id="paginationContainer" class="d-flex justify-content-end">
                    <ul class="pagination"></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    @include('admin.partials.add-book-modal')
    @foreach ($books as $book)
        @include('admin.partials.edit-book-modal', ['book' => $book])
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loanTableBody = document.getElementById('loanTableBody');
            const paginationContainer = document.getElementById('paginationContainer');

            // Simulez vos données
            let loans = @json($loanHistories);

            // Variables de pagination
            const itemsPerPage = 10; // Nombre d'éléments par page
            let currentPage = 1; // Page actuelle
            let currentSort = { key: 'start_loan', order: 'asc' }; // Tri par défaut
            let currentFilter = 'all'; // Filtre actuel

            // Fonction pour trier les données
            function sortLoans(loans, key, order) {
                return loans.sort((a, b) => {
                    let valueA = a[key];
                    let valueB = b[key];

                    if (key === 'start_loan' || key === 'end_loan') {
                        valueA = new Date(valueA).getTime();
                        valueB = new Date(valueB).getTime();
                    }

                    if (order === 'asc') {
                        return valueA > valueB ? 1 : -1;
                    } else {
                        return valueA < valueB ? 1 : -1;
                    }
                });
            }

            // Fonction pour filtrer les données
            function filterLoans(loans) {
                const now = new Date();
                const twoMonthsAgo = new Date();
                twoMonthsAgo.setMonth(twoMonthsAgo.getMonth() - 2);

                return loans.filter(loan => {
                    if (currentFilter === 'not-returned') {
                        return !loan.end_loan; // Livres non rendus
                    } else if (currentFilter === 'overdue') {
                        return !loan.end_loan && new Date(loan.start_loan) < twoMonthsAgo; // Non rendus + emprunt vieux de 2 mois
                    } else {
                        return true; // Tous les livres
                    }
                });
            }

            // Fonction pour afficher les données paginées
            function renderTable(page = 1) {
                // Trier et filtrer avant de paginer
                const filteredLoans = filterLoans(loans);
                const sortedLoans = sortLoans(filteredLoans, currentSort.key, currentSort.order);

                // Calcule l'index de début et de fin des éléments pour la page actuelle
                const startIndex = (page - 1) * itemsPerPage;
                const endIndex = startIndex + itemsPerPage;
                const paginatedLoans = sortedLoans.slice(startIndex, endIndex);

                // Vide le tableau
                loanTableBody.innerHTML = '';

                // Ajoute les données paginées dans le tableau
                if (paginatedLoans.length === 0) {
                    loanTableBody.innerHTML = `<tr><td colspan="4" class="text-center">Aucun livre emprunté correspondant.</td></tr>`;
                } else {
                    paginatedLoans.forEach(loan => {
                        const row = `
                        <tr>
                            <td style="padding: 9.45px 8px">${loan.copy.book.name_book}</td>
                            <td style="padding: 9.45px 8px">${loan.user.first_name_user} ${loan.user.last_name_user.toUpperCase()}</td>
                            <td style="padding: 9.45px 8px">${new Date(loan.start_loan).toLocaleDateString()}</td>
                            <td style="padding: 9.45px 8px">${loan.end_loan ? new Date(loan.end_loan).toLocaleDateString() : '<span class="text-danger">En cours</span>'}</td>
                        </tr>
                    `;
                        loanTableBody.innerHTML += row;
                    });
                }
            }

            // Fonction pour générer les boutons de pagination
            function renderPagination() {
                const filteredLoans = filterLoans(loans);
                const totalPages = Math.ceil(filteredLoans.length / itemsPerPage);

                // Vide la pagination
                const paginationList = paginationContainer.querySelector('.pagination');
                paginationList.innerHTML = '';

                // Ajouter le bouton "Previous"
                const previousLi = document.createElement('li');
                previousLi.classList.add('page-item');
                if (currentPage === 1) {
                    previousLi.classList.add('disabled'); // Désactiver le bouton si c'est la première page
                }
                previousLi.innerHTML = `
        <a href="#" class="page-link" aria-label="Previous" data-page="${currentPage - 1}">
            <span aria-hidden="true">‹</span>
        </a>
    `;
                previousLi.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (currentPage > 1) {
                        currentPage--;
                        renderTable(currentPage);
                        renderPagination();
                    }
                });
                paginationList.appendChild(previousLi);

                // Ajouter les numéros de pages
                for (let i = 1; i <= totalPages; i++) {
                    const li = document.createElement('li');
                    li.classList.add('page-item');
                    if (i === currentPage) {
                        li.classList.add('active');
                    }
                    li.innerHTML = `
            <a href="#" class="page-link" data-page="${i}">${i}</a>
        `;
                    li.addEventListener('click', function (e) {
                        e.preventDefault();
                        currentPage = parseInt(e.target.getAttribute('data-page'));
                        renderTable(currentPage);
                        renderPagination();
                    });
                    paginationList.appendChild(li);
                }

                // Ajouter le bouton "Next"
                const nextLi = document.createElement('li');
                nextLi.classList.add('page-item');
                if (currentPage === totalPages) {
                    nextLi.classList.add('disabled'); // Désactiver le bouton si c'est la dernière page
                }
                nextLi.innerHTML = `
                    <a href="#" class="page-link" aria-label="Next" data-page="${currentPage + 1}">
                        <span aria-hidden="true">›</span>
                    </a>
                    `;
                nextLi.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (currentPage < totalPages) {
                        currentPage++;
                        renderTable(currentPage);
                        renderPagination();
                    }
                });
                paginationList.appendChild(nextLi);

            }

            // Fonction pour gérer les événements de tri
            function addSortingListeners() {
                const headers = document.querySelectorAll('[data-sort-key]');
                headers.forEach(header => {
                    header.addEventListener('click', function () {
                        const key = this.getAttribute('data-sort-key');
                        const order = currentSort.key === key && currentSort.order === 'asc' ? 'desc' : 'asc';
                        currentSort = { key, order };

                        // Réinitialiser à la première page et recharger
                        currentPage = 1;
                        renderTable(currentPage);
                        renderPagination();
                    });
                });
            }

            // Fonction pour gérer les événements de filtre
            function addFilterListeners() {
                const allBtn = document.getElementById('filterAllBtn');
                const notReturnedBtn = document.getElementById('filterNotReturnedBtn');
                const overdueBtn = document.getElementById('filterOverdueBtn');

                allBtn.addEventListener('click', function () {
                    currentFilter = 'all';
                    toggleActiveButton(allBtn);
                    renderTable(currentPage);
                    renderPagination();
                });

                notReturnedBtn.addEventListener('click', function () {
                    currentFilter = 'not-returned';
                    toggleActiveButton(notReturnedBtn);
                    renderTable(currentPage);
                    renderPagination();
                });

                overdueBtn.addEventListener('click', function () {
                    currentFilter = 'overdue';
                    toggleActiveButton(overdueBtn);
                    renderTable(currentPage);
                    renderPagination();
                });
            }

            // Fonction pour ajouter/remplacer les classes des boutons
            function toggleActiveButton(selectedBtn) {
                const allBtns = document.querySelectorAll('.filter-btn');

                allBtns.forEach(btn => {
                    // Retirer la classe 'btn-primary', 'btn-success', ou 'btn-danger' de tous les boutons
                    btn.classList.remove('btn-primary', 'btn-success', 'btn-danger');

                    // Ajouter la classe correspondante en fonction du bouton (non sélectionné)
                    if (btn.id === 'filterAllBtn') {
                        btn.classList.add('btn-outline-primary');
                        btn.classList.remove('btn-primary');
                    } else if (btn.id === 'filterNotReturnedBtn') {
                        btn.classList.add('btn-outline-success');
                        btn.classList.remove('btn-success');
                    } else if (btn.id === 'filterOverdueBtn') {
                        btn.classList.add('btn-outline-danger');
                        btn.classList.remove('btn-danger');
                    }

                    // Si le bouton sélectionné, lui ajouter la classe appropriée
                    if (btn === selectedBtn) {
                        if (btn.id === 'filterAllBtn') {
                            btn.classList.add('btn-primary');
                            btn.classList.remove('btn-outline-primary');
                        } else if (btn.id === 'filterNotReturnedBtn') {
                            btn.classList.add('btn-success');
                            btn.classList.remove('btn-outline-success');
                        } else if (btn.id === 'filterOverdueBtn') {
                            btn.classList.add('btn-danger');
                            btn.classList.remove('btn-outline-danger');
                        }
                    }
                });
            }

            // Initialiser le tableau et la pagination
            renderTable(currentPage);
            renderPagination();
            addSortingListeners();
            addFilterListeners();
        });
    </script>
@endsection
