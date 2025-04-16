

<div>
    <!-- Styles personnalisés pour un rendu moderne -->
<style>
    .modal-content {
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
    }
    .modal-header {
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        color: white;
        align-items: center;
    }
    .modal-header p {
        margin-bottom: 0;
        margin-left: 1rem;
        font-size: 0.9rem;
    }
    .modal-body {
        background-color: #f9fafb;
    }
    .modal-footer {
        background-color: #f1f5f9;
    }
    .info-card {
        background-color: #ffffff;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .info-card h5 {
        margin-bottom: 0.5rem;
    }
    .info-card ul {
        padding-left: 1.2rem;
    }
    .info-card li {
        margin-bottom: 0.5rem;
    }
</style>
    <!-- Bouton d'ouverture de la modale -->
    <span type="button" data-bs-toggle="modal" data-bs-target="#voirDetail-{{ $client->id }}" style="font-size: x-large; cursor: pointer;">
        👁
    </span>

    <!-- Modale -->
    <div class="modal fade" id="voirDetail-{{ $client->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $client->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 60%; margin: 1.75rem auto;">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h2 class="modal-title fs-5" id="modalLabel-{{ $client->id }}">Activité du client</h2>
                        <p>👤<strong>{{ $client->nom }}</strong> | 📞<strong>{{ $client->numero }}</strong></p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- Colonne Ventes -->
                            <div class="col-md-6">
                                @if($client->ventes)
                                    <h4 class="mb-3"><u>{{ $client->ventes->count() }} Ventes</u></h4>
                                    @php $totalVentes = 0; @endphp
                                    @foreach($client->ventes as $vente)
                                        @php $totalVentes++; @endphp
                                        <div class="info-card">
                                            <h5>Vente N°: {{ $totalVentes }} 
                                                <small class="text-muted">le {{ $vente->created_at }}</small>
                                            </h5>
                                            <p>Facture N°: <strong>{{ $vente->factures->numeroFacture ?? 'Non défini' }}</strong></p>
                                            @if($vente->produits)
                                                <ul class="list-unstyled">
                                                    @foreach($vente->produits as $produit)
                                                        <li>
                                                            <span class="fw-bold">Produit:</span> {{ $produit->name }} <br>
                                                            <span class="fw-bold">Qte:</span> {{ $produit->pivot->quantity }}
                                                            - <span class="fw-bold">Prix:</span> {{ $produit->pivot->price }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <!-- Colonne Installations -->
                            <div class="col-md-6">
                                @if($client->installations)
                                    <h4 class="mb-3"><u>{{ $client->installations->count() }} Installations</u></h4>
                                    @php $totalInstallations = 0; @endphp
                                    @foreach($client->installations as $installation)
                                        @php $totalInstallations++; @endphp
                                        <div class="info-card">
                                            <h5>Installation N°: {{ $totalInstallations }} 
                                                <small class="text-muted">le {{ \Carbon\Carbon::parse($installation->created_at)->format('d/m/Y') }}</small>
                                            </h5>
                                            <p>Facture N°: <strong>{{ $installation->factures->numeroFacture ?? 'Non défini' }}</strong></p>
                                            @if($installation->produits)
                                                <ul class="list-unstyled">
                                                    @foreach($installation->produits as $produit)
                                                        <li>
                                                            <span class="fw-bold">Produit:</span> {{ $produit->name }} <br>
                                                            <span class="fw-bold">Qte:</span> {{ $produit->pivot->quantity }}
                                                            - <span class="fw-bold">Prix:</span> {{ $produit->pivot->price }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</div>
