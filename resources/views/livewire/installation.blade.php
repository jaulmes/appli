<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
            <h4 class="mb-0 fw-bold text-primary">Liste des installations</h4>
            <div class="input-group input-group-sm w-auto">
                <input type="search" class="form-control" placeholder="Rechercher..." wire:model="query" wire:input="update_search">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="card-body p-0" style="max-height: 500px; overflow-y: auto;">
            <table class="table table-hover table-bordered text-nowrap align-middle" style="height: 400px; font-size: x-small;">
                <thead class="table-primary text-center">
                    <tr>
                        <th>Client</th>
                        <th>Numéro</th>
                        <th>Auteur</th>
                        <th>Produits</th>
                        <th>Commission</th>
                        <th>Total Produits</th>
                        <th>Réduction</th>
                        <th>Main d'œuvre</th>
                        <th>Net à Payer</th>
                        <th>Versé</th>
                        <th>Reste</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="result">
                    @foreach($installations as $installation)
                    <tr>
                        <td>{{ $installation->nomClient?? $installation->clients->nom?? 'N/A' }}</td>
                        <td>{{ $installation->numeroClient }}</td>
                        <td>{{ $installation->user->name }}</td>
                        <td>
                            @foreach($installation->produits as $produit)
                                <span class="d-block small">
                                    <strong>Qte:</strong> {{ $produit->pivot->quantity }},
                                    <strong>Titre:</strong> {{ $produit->name }},
                                    <strong>Prix:</strong> {{ number_format($produit->pivot->price, 0, ',', ' ') }} FCFA
                                </span>
                            @endforeach
                        </td>
                        <td>{{ number_format($installation->commission, 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($installation->montantProduit, 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($installation->reduction, 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($installation->mainOeuvre, 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($installation->NetAPayer, 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($installation->montantVerse, 0, ',', ' ') }} FCFA</td>
                        <td class="text-danger fw-bold">
                            {{ number_format($installation->NetAPayer - $installation->montantVerse, 0, ',', ' ') }} FCFA
                        </td>
                        <td>{{ $installation->created_at->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge {{ $installation->statut == 'non termine' ? 'bg-warning text-dark' : 'bg-success' }}">
                                {{ ucfirst($installation->statut) }}
                            </span>
                        </td>
                        <td>
                            @if($installation->statut == 'non termine')
                            <a href="{{ route('installations.voir.ajouterPaiement', $installation->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus"></i> Paiement
                            </a>
                            @else
                            <span class="text-muted small">Complété</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
