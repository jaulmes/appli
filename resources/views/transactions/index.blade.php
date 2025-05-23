@extends('dashboard.main')

@section('content')
<div class="container-fluid my-4">
    <!-- Message d'alerte -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Journal des Activités -->
    <div class="card shadow-sm">
        <div class="card-header d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
            <h3 class="card-title mb-0"><strong>Journal des Activités</strong></h3>
            
            <div class="d-flex flex-wrap gap-2">
                <form method="GET" action="{{ route('transaction.bilan') }}" class="d-flex align-items-center">
                    @csrf
                    <input type="hidden" name="month" id="bilanMonth" value="{{ $currentMonth }}">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-chart-line me-1"></i>
                        Afficher le bilan du mois
                    </button>
                </form>
                
                <form method="GET" action="{{ route('transaction.index') }}">
                    @csrf
                    <div class="input-group input-group-sm" style="width: 180px;">
                        <select name="month" id="transactionMonth" class="form-select" onchange="this.form.submit()">
                            @for($i = 0; $i < 12; $i++)
                                @php
                                    $month = \Carbon\Carbon::now()->subMonths($i)->format('Y-m');
                                @endphp
                                <option value="{{ $month }}" {{ $currentMonth == $month ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::parse($month)->format('F Y') }}
                                </option>
                            @endfor
                        </select>
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 450px;">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light sticky-top" style="z-index: 1;">
                        <tr>
                            <th>Nom client</th>
                            <th>Num client</th>
                            <th>Auteur</th>
                            @can('VOIR_UTILISATEURS')
                                <th>Prix achat</th>
                            @endcan
                            <th>Montant Verse</th>
                            <th>Moyen paiement</th>
                            <th>Produits</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Heure</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                            <tr class="align-middle small">
                                <td>{{ $transaction->nomClient ?? $transaction->recus->clients->nom ?? $transaction->recus->ventes->commandes->clients->nom ?? $transaction->ventes->clients->nom?? '-' }}</td>
                                <td>{{ $transaction->numeroClient ?? $transaction->recus->clients->numero ?? $transaction->recus->ventes->commandes->clients->numero ?? $transaction->ventes->clients->numero?? '-' }}</td>
                                <td>
                                    {{ $transaction->user->name ?? $transaction->recus->users->name ?? $transaction->ventes->user->name?? 'Aucun nom' }}
                                </td>
                                @can('VOIR_UTILISATEURS')
                                    <td>{{ $transaction->prixAchat?? $transaction->ventes->totalAchat?? '-' }}</td>
                                @endcan
                                <td>{{ $transaction->montantVerse ?? $transaction->recus->montant_recu ?? $transaction->ventes->montantVerse?? '-' }}</td>
                                <td>{{ $transaction->compte->nom ?? $transaction->ventes->compte->nom?? '-' }}</td>
                                <td class="text-wrap">
                                    @if($transaction->charge_id)
                                        {{ $transaction->charges->titre }}
                                    @elseif($transaction->recus)
                                        @if($transaction->recus->installations)
                                            @foreach($transaction->recus->installations->produits as $produit)
                                                <div class="mb-1">
                                                    <small>
                                                        Qte: {{ $produit->pivot->quantity }} - PU: {{ $produit->pivot->price }} - {{ $produit->name }}
                                                    </small>
                                                </div>
                                            @endforeach
                                        @elseif($transaction->recus->ventes)
                                            @foreach($transaction->recus->ventes->produits as $produit)
                                                <div class="mb-1">
                                                    <small>
                                                        Qte: {{ $produit->pivot->quantity }} - PU: {{ $produit->pivot->price }} - {{ $produit->name }}
                                                    </small>
                                                </div>
                                            @endforeach
                                        @else
                                            <small>Aucun produit renseigné</small>
                                        @endif
                                    @else
                                        @if($transaction->ventes)
                                            @foreach($transaction->ventes->packs as $pack)
                                                <div class="mb-1">
                                                    <small>
                                                        Qte: {{ $pack->pivot->quantity }} - PU: {{ $pack->pivot->price }} - {{ $pack->titre }}
                                                    </small>
                                                </div>
                                            @endforeach
                                        @else
                                            @forelse($transaction->produits as $produit)
                                                <div class="mb-1">
                                                    <small>
                                                        Qte: {{ $produit->pivot->quantity }} - PU: {{ $produit->pivot->price }} - {{ $produit->name }}
                                                    </small>
                                                </div>
                                            @empty
                                                <small>{{ $transaction->produit }}</small>
                                            @endforelse
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $transaction->type }}</td>
                                <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y') }}</td>
                                <td>{{ $transaction->created_at->format('h:m:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    // Permet de synchroniser le mois sélectionné du formulaire de transactions avec le bilan
    document.getElementById('transactionMonth').addEventListener('change', function() {
        document.getElementById('bilanMonth').value = this.value;
    });
</script>
@endsection
