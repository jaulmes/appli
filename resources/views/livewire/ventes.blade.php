<div class="card shadow-lg border-0">
<div class="card-header bg-light border-bottom-0">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
            <!-- Titre -->
            <h4 class="mb-3 mb-md-0 text-primary font-weight-bold">Filtrer les résultats</h4>

            <!-- Filtres -->
            <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
                <button type="button" 
                        class="btn btn-filter {{ $type === 'all' ? 'active' : '' }} " 
                        wire:click="filter('all')">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-layer-group"></i>
                        <span>Tous</span>
                    </div>
                </button>

                <button type="button" 
                        class="btn btn-filter {{ $type === 'non_termine' ? 'active' : '' }}" 
                        wire:click="filter('non_termine')">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-clock text-warning"></i>
                        <span>En cours</span>
                        <span class="badge bg-white text-warning ml-1">{{ $nbreNonTermine }}</span>
                    </div>
                </button>

                <button type="button" 
                        class="btn btn-filter {{ $type === 'termine' ? 'active' : '' }}" 
                        wire:click="filter('termine')">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-check-circle text-success"></i>
                        <span>Terminés</span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <style>
    .btn-filter {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
        background: white;
        color: #6c757d;
        position: relative;
        overflow: hidden;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .btn-filter.active {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-color: #007bff;
        color: #007bff;
        font-weight: 500;
    }

    .btn-filter.active::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: #007bff;
    }

    .btn-filter i {
        font-size: 1.1em;
        transition: transform 0.3s ease;
    }

    .btn-filter.active i {
        transform: scale(1.2);
    }

    @media (max-width: 768px) {
        .btn-filter {
            width: 100%;
            justify-content: start;
        }
    }
    </style>
    <div class="card-header bg-primary text-white d-flex flex-column flex-md-row justify-content-between align-items-center">
        <h3 class="card-title mb-3 mb-md-0 font-weight-bold">Liste des Ventes</h3>
        <div class="w-100 w-md-auto">
            <div class="input-group">
                <input type="text" 
                       wire:model.debounce.300ms="search"
                       class="form-control form-control-lg border-0"
                       placeholder="Rechercher..."
                       aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-light" type="button">
                        <i class="fas fa-search text-primary"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="text-nowrap">Client</th>
                        <th class="d-none d-md-table-cell">Contact</th>
                        <th class="d-none d-lg-table-cell">Agent</th>
                        <th class="text-center">Montant Affiché</th>
                        <th class="text-center">Montant Arrété</th>
                        <th class="d-none d-sm-table-cell text-right">Payé</th>
                        <th class="text-right">Reste</th>
                        <th class="d-none d-lg-table-cell">Statut</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventes as $vente)
                    <tr class="cursor-pointer">
                        <!-- Colonne Client (toujours visible) -->
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-info text-white rounded-circle mr-2 d-flex align-items-center justify-content-center">
                                    {{ substr($vente->clients->nom ?? 'N/A', 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-weight-bold">
                                        {{ $vente->clients->nom ?? $vente->commandes->clients->nom ?? $vente->nomClient }}
                                    </div>
                                    <small class="text-muted d-block d-md-none">
                                        {{ $vente->clients->numero ?? $vente->commandes->clients->numero ?? $vente->numeroClient }}
                                    </small>
                                </div>
                            </div>
                        </td>

                        <!-- Colonne Contact (masquée sur mobile) -->
                        <td class="d-none d-md-table-cell">
                            {{ $vente->clients->numero ?? $vente->commandes->clients->numero ?? $vente->numeroClient }}
                        </td>

                        <!-- Colonne Agent (masquée sur petit écran) -->
                        <td class="d-none d-lg-table-cell">
                            <div class="text-truncate" style="max-width: 150px;">
                                {{ $vente->user->name }}
                                <small class="text-muted d-block">{{ $vente->agentOperant }}</small>
                            </div>
                        </td>

                        <!-- Colonnes Montants -->
                        <td class="text-right font-weight-bold text-primary">
                            {{ number_format($vente->montantTotal, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="text-right font-weight-bold text-primary">
                            {{ number_format($vente->NetAPayer, 0, ',', ' ') }} FCFA
                        </td>

                        <td class="d-none d-sm-table-cell text-right">
                            {{ number_format($vente->montantVerse, 0, ',', ' ') }} FCFA
                        </td>

                        <td class="text-right">
                            <span class="{{ $vente->NetAPayer - $vente->montantVerse > 0 ? 'text-danger' : 'text-success' }}">
                                {{ number_format($vente->NetAPayer - $vente->montantVerse, 0, ',', ' ') }} FCFA
                            </span>
                        </td>

                        <!-- Statut (masquée sur mobile) -->
                        <td class="d-none d-lg-table-cell">
                            <span class="badge badge-pill 
                                @if($vente->statut === 'Payé') badge-success
                                @elseif($vente->statut === 'En Attente') badge-warning
                                @else badge-secondary @endif">
                                {{ $vente->statut }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="text-center">
                            @if($vente->NetAPayer - $vente->montantVerse > 0)
                            <a href="{{ route('ventes.voir.ajouterPaiement', $vente->id)}}" 
                               class="btn btn-sm btn-icon btn-primary"
                               data-toggle="tooltip"
                               title="Ajouter un paiement">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                            @else
                            <span class="text-success">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <style>
    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transform: translateX(4px);
        transition: all 0.2s ease;
    }

    @media (max-width: 768px) {
        .card-header {
            padding: 1rem;
        }
        
        .table td, .table th {
            padding: 0.75rem 0.5rem;
        }
        
        .btn-icon {
            padding: 0.25rem 0.5rem;
        }
    }
</style>
</div>

