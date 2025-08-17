<div class="container-fluid my-4" style="font-size: 14px;">
    <!-- Titre -->
    <div class="text-center mb-4">
        <h4 class="text-uppercase fw-bold text-primary">
            <i class="fas fa-money-bill-wave me-2"></i>Investissement du mois
        </h4>
        <p class="text-muted">Détail des produits achetés durant le mois {{ number_format($montantInvesti, 0, ".", " ")}}</p>
    </div>

    <!-- Tableau -->
    <div class="table-responsive rounded shadow-sm" style="max-height: 500px; overflow-y: auto;">
        <table class="table table-hover align-middle table-bordered bg-white">
            <thead class="bg-primary text-white sticky-top">
                <tr class="text-center">
                    <th style="width: 30%"><i class="fas fa-box me-1"></i> Produit</th>
                    <th><i class="fas fa-calendar-alt me-1"></i> Date d’achat</th>
                    <th><i class="fas fa-sort-numeric-up me-1"></i> Quantité</th>
                    <th><i class="fas fa-coins me-1"></i> Prix Unitaire (FCFA)</th>
                    <th><i class="fas fa-money-check-alt me-1"></i> Montant Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($achats as $achat)
                    @foreach($achat->produits as $produit)
                        <tr class="text-center">
                            <td class="fw-semibold text-start">
                                <i class="fas fa-cube text-secondary me-1"></i> {{ $produit->name }}
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ \Carbon\Carbon::parse($achat->created_at)->locale('fr_FR')->isoFormat('D MMM YYYY') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $produit->pivot->quantity }}</span>
                            </td>
                            <td>{{ number_format($produit->prix_achat, 0, ',', ' ') }}</td>
                            <td class="fw-bold text-success">
                                {{ number_format($produit->pivot->quantity * $produit->prix_achat, 0, ',', ' ') }}
                            </td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="fas fa-info-circle me-2"></i>Aucun produit enregistré pour ce mois.
                        </td>
                    </tr>
                @endforelse
            </tbody>

            <!-- Footer : total global -->
            @if($achats->isNotEmpty())
                <tfoot class="table-light fw-bold">
                    <tr class="text-center">
                        <td colspan="4" class="text-end">Total Général :</td>
                        <td class="text-success">
                            {{ number_format($achats->flatMap->produits->sum(fn($p) => $p->pivot->quantity * $p->prix_achat), 0, ',', ' ') }}
                        </td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>
</div>
