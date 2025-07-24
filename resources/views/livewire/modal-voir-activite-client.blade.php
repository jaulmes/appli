<div>
    <!-- Styles personnalisés optimisés -->
    <style>
        .custom-modal {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .modal-header-custom {
            background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 100%);
            color: white;
            padding: 1.5rem;
        }
        .modal-body-custom {
            background-color: #f8fafc;
            padding: 0;
        }
        .info-card {
            background-color: white;
            border-radius: 0.75rem;
            padding: 1.25rem;
            margin-bottom: 1.25rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-left: 4px solid #3b82f6;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .section-title {
            position: relative;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .section-title:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
            border-radius: 3px;
        }
        .badge-count {
            background-color: #3b82f6;
            color: white;
            font-size: 0.8rem;
            padding: 0.35rem 0.65rem;
            border-radius: 50rem;
        }
        .product-item {
            border-left: 2px solid #e2e8f0;
            padding-left: 0.75rem;
            margin-bottom: 0.75rem;
        }
        .btn-modal-trigger {
            transition: all 0.3s;
            border: none;
            background: transparent;
            color: #3b82f6;
            padding: 0;
            font-size: 1.1rem;
        }
        .btn-modal-trigger:hover {
            color: #2563eb;
            transform: translateY(-1px);
        }
    </style>

    <!-- Bouton déclencheur amélioré -->
    <button type="button" class="btn-modal-trigger" data-bs-toggle="modal" data-bs-target="#voirDetail-{{ $client->id }}">
        <i class="fas fa-chart-line me-2"></i>Voir activités complètes
    </button>

    <!-- Modale améliorée -->
    <div class="modal fade" id="voirDetail-{{ $client->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $client->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content custom-modal">
                <!-- En-tête amélioré -->
                <div class="modal-header modal-header-custom">
                    <div class="w-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h2 class="modal-title mb-0">
                                <i class="fas fa-chart-pie me-2"></i>Historique d'activités
                            </h2>
                            <span class="badge bg-white text-primary fs-6">
                                <i class="fas fa-user me-1"></i> {{ $client->nom }}
                            </span>
                        </div>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-phone-alt me-2"></i>
                                <span>{{ $client->numero }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>Client depuis {{ $client->created_at->format('m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Corps de la modale réorganisé -->
                <div class="modal-body modal-body-custom">
                    <div class="container-fluid p-4">
                        <div class="row g-4">
                            <!-- Colonne Ventes -->
                            <div class="col-lg-6">
                                <div class="sticky-top pt-3" style="top: 1rem; z-index: 1;">
                                    <h3 class="section-title">
                                        <i class="fas fa-shopping-cart me-2"></i>Historique des ventes
                                        <span class="badge-count ms-2">{{ $client->ventes->count() }}</span>
                                    </h3>
                                </div>

                                @if($client->ventes->isEmpty())
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>Aucune vente enregistrée pour ce client
                                    </div>
                                @else
                                    @foreach($client->ventes as $index => $vente)
                                        <div class="info-card">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h5 class="mb-0">
                                                    Vente #{{ $index + 1 }}
                                                    <small class="text-muted ms-2">{{ $vente->created_at->format('d/m/Y à H:i') }}</small>
                                                </h5>
                                                @if($vente->factures)
                                                    <span class="badge bg-success bg-opacity-10 text-success">
                                                        Facture: {{ $vente->factures->numeroFacture }}
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            @if($vente->produits->isNotEmpty())
                                                <div class="mt-3">
                                                    <h6 class="text-muted mb-2">Produits:</h6>
                                                    @foreach($vente->produits as $produit)
                                                        <div class="product-item">
                                                            <div class="d-flex justify-content-between">
                                                                <strong>{{ $produit->name }}</strong>
                                                                <span>{{ $produit->pivot->quantity }} × {{ number_format($produit->pivot->price, 2) }} </span>
                                                            </div>
                                                            <div class="d-flex justify-content-between text-muted small">
                                                                <span>Réf: {{ $produit->reference ?? 'N/A' }}</span>
                                                                <strong>Total: {{ number_format($produit->pivot->quantity * $produit->pivot->price, 2) }} </strong>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- Colonne Installations -->
                            <div class="col-lg-6">
                                <div class="sticky-top pt-3" style="top: 1rem; z-index: 1;">
                                    <h3 class="section-title">
                                        <i class="fas fa-tools me-2"></i>Historique des installations
                                        <span class="badge-count ms-2">{{ $client->installations->count() }}</span>
                                    </h3>
                                </div>

                                @if($client->installations->isEmpty())
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>Aucune installation enregistrée pour ce client
                                    </div>
                                @else
                                    @foreach($client->installations as $index => $installation)
                                        <div class="info-card">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h5 class="mb-0">
                                                    Installation #{{ $index + 1 }}
                                                    <small class="text-muted ms-2">{{ $installation->created_at->format('d/m/Y à H:i') }}</small>
                                                </h5>
                                                @if($installation->factures)
                                                    <span class="badge bg-success bg-opacity-10 text-success">
                                                        Facture: {{ $installation->factures->numeroFacture }}
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            @if($installation->produits->isNotEmpty())
                                                <div class="mt-3">
                                                    <h6 class="text-muted mb-2">Équipements installés:</h6>
                                                    @foreach($installation->produits as $produit)
                                                        <div class="product-item">
                                                            <div class="d-flex justify-content-between">
                                                                <strong>{{ $produit->name }}</strong>
                                                                <span>{{ $produit->pivot->quantity }} × {{ number_format($produit->pivot->price, 2) }} </span>
                                                            </div>
                                                            <div class="d-flex justify-content-between text-muted small">
                                                                <span>Réf: {{ $produit->reference ?? 'N/A' }}</span>
                                                                <strong>Total: {{ number_format($produit->pivot->quantity * $produit->pivot->price, 2) }} </strong>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pied de page amélioré -->
                <div class="modal-footer bg-light">
                    <div class="d-flex justify-content-between w-100">
                        <div>
                            <span class="text-muted small">
                                <i class="fas fa-sync-alt me-1"></i> Dernière mise à jour: {{ now()->format('d/m/Y H:i') }}
                            </span>
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Fermer
                            </button>
                            <button type="button" class="btn btn-primary">
                                <i class="fas fa-print me-1"></i> Exporter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>