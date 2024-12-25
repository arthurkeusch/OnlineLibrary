@extends('layouts.app')

@section('title', "Dashboard")

@section('content')
    <div class="container mt-5">
        <h3 class="mt-4">Vos livres empruntés</h3>

        @if($loanedBooks->isEmpty())
            <div class="alert alert-info mt-4" role="alert">
                Vous n'avez encore emprunté aucun livre.
            </div>
        @else
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                    <tr>
                        <th>Titre</th>
                        <th>Date d'emprunt</th>
                        <th>Date de retour</th>
                        <th>État</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($loanedBooks as $loan)
                        @php
                            $stateColors = [
                                1 => 'bg-success',
                                2 => 'bg-primary',
                                3 => 'bg-info',
                                4 => 'bg-secondary',
                                5 => 'bg-warning',
                                6 => 'bg-danger',
                            ];
                            $badgeColor = $stateColors[$loan->copy->state->id_state] ?? 'bg-secondary';
                        @endphp
                        <tr>
                            <td>{{ $loan->copy->book->name_book }}</td>
                            <td>{{ $loan->start_loan->format('d/m/Y') }}</td>
                            <td>
                                @if(!$loan->end_loan)
                                    <form action="{{ route('user.returnBook', $loan->id_loanhistory) }}" method="POST"
                                          style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Rendre</button>
                                    </form>
                                @else
                                    {{ $loan->end_loan->format('d/m/Y') }}
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $badgeColor }}">
                                    {{ $loan->copy->state->name_state }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
