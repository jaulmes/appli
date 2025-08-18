<div class="card shadow-sm">
    <div class="card-header d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 row">
        <h3 class="card-title mb-0 col"><strong>Journal des Activités</strong></h3>
        <div class="d-flex flex-wrap gap-2 col">
            <a href="{{route('transaction.bilan', ['moi' => $moisSelectionne])}}">                
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-chart-line me-1"></i>
                    Afficher le bilan du mois
                </button>
            </a>
            <div class="mb-4">
                <input type="month" wire:change="getTransactionsProperty()" id="mois" wire:model="moisSelectionne" class="form-control">
            </div>
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
                            <td>{{$transaction->clients->nom?? $transaction->suivis->clients->nom?? $transaction->ventes?->clients?->nom?? $transaction->nomClient ?? $transaction->recus?->clients?->nom ?? $transaction->recus?->ventes?->commandes?->clients?->nom?? $transaction->proformats?->clients->nom  }}</td>
                            <td>{{$transaction->clients->numero?? $transaction->suivis->clients->numero?? $transaction->numeroClient ?? $transaction->recus->clients->numero ?? $transaction->recus->ventes->commandes->clients->numero ?? $transaction->ventes->clients->numero?? $transaction->proformats?->clients->numero?? '-' }}</td>
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
                                        @forelse($transaction->ventes->packs as $pack)
                                            <div class="mb-1">
                                                <small>
                                                    Qte: {{ $pack->pivot->quantity }} - PU: {{ $pack->pivot->price }} - {{ $pack->titre }}
                                                </small>
                                            </div>
                                        @empty
                                            @foreach($transaction->ventes->produits as $produit)
                                                <div class="mb-1">
                                                    <small>
                                                        Qte: {{ $produit->pivot->quantity }} - PU: {{ $produit->pivot->price }} - {{ $produit->name }}
                                                    </small>
                                                </div>
                                            @endforeach
                                        @endforelse
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
                            <td>{{ $transaction->created_at->format('H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>