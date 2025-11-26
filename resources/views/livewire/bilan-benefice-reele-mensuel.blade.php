<div class="container my-4">
    <!-- En-tête avec gradient -->
    <div class="text-center mb-5">
        <h3 class="fw-bold mb-2">
            <i class="bi bi-bar-chart-line-fill text-primary me-2"></i>
            Bilan Financier
        </h3>
        <h5 class="text-primary fw-semibold">
            {{ \Carbon\Carbon::parse($moisSelectionne)->translatedFormat('F Y') }}
        </h5>
        <p class="text-muted mb-0">Analyse complète de votre performance financière mensuelle</p>
    </div>

    <!-- Cartes Financières -->
    <div class="row g-3 mb-5">
        @php
        $cards = [
            ['icon' => 'bi-currency-dollar', 'label' => 'Chiffre d\'Affaires', 'value' => $chiffreAffaire, 'color' => 'info', 'bg' => 'bg-info-subtle'],
            ['icon' => 'bi-cash-coin', 'label' => 'Bénéfice Brut', 'value' => $beneficeBrute, 'color' => 'success', 'bg' => 'bg-success-subtle'],
            ['icon' => 'bi-receipt', 'label' => 'Total des Charges', 'value' => $totalCharge, 'color' => 'danger', 'bg' => 'bg-danger-subtle'],
            ['icon' => 'bi-graph-up-arrow', 'label' => 'Bénéfice Réel', 'value' => $beneficeReele, 'color' => 'primary', 'bg' => 'bg-primary-subtle'],
            ['icon' => 'bi-piggy-bank', 'label' => 'Montant Investi', 'value' => $montantInvesti, 'color' => 'warning', 'bg' => 'bg-warning-subtle'],
        ];
        @endphp

        @foreach ($cards as $card)
        <div class="col-lg col-md-4 col-sm-6">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box {{ $card['bg'] }} rounded-3 p-2 me-3">
                            <i class="bi {{ $card['icon'] }} text-{{ $card['color'] }} fs-3"></i>
                        </div>
                        <h6 class="text-muted mb-0 small">{{ $card['label'] }}</h6>
                    </div>
                    <h4 class="fw-bold text-{{ $card['color'] }} mb-0">
                        {{ number_format($card['value'], 0, ',', ' ') }}
                        <small class="fs-6 text-muted">FCFA</small>
                    </h4>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- État des Comptes -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex align-items-center">
                <i class="bi bi-bank2 text-primary fs-4 me-2"></i>
                <h5 class="fw-bold mb-0 text-primary">État des Comptes</h5>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                @forelse ($etatCompteMensuel as $compte)
                <div class="col-lg-4 col-md-6">
                    <div class="card border shadow-sm h-100 hover-lift">
                        <div class="card-body p-4">
                            <!-- En-tête du compte -->
                            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                <div class="rounded-circle bg-light p-2 me-2">
                                    <i class="bi bi-wallet2 text-secondary"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-0">{{ $compte['name'] }}</h6>
                            </div>

                            <!-- Solde Début -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">
                                        <i class="bi bi-calendar-check me-1"></i>Solde initial
                                    </span>
                                    <span class="badge bg-light text-info border border-info">
                                        {{ number_format($compte['solde_debut'], 0, ',', ' ') }} FCFA
                                    </span>
                                </div>
                            </div>

                            <!-- Solde Fin -->
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">
                                        <i class="bi bi-calendar-event me-1"></i>Solde final
                                    </span>
                                    <span class="fw-bold fs-5 {{ $compte['variation'] >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($compte['solde_fin'], 0, ',', ' ') }} FCFA
                                    </span>
                                </div>
                            </div>

                            <!-- Variation avec badge -->
                            <div class="mt-3 pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">Variation</span>
                                    <span class="badge {{ $compte['variation'] >= 0 ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                        <i class="bi {{ $compte['variation'] >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' }} me-1"></i>
                                        {{ $compte['variation'] >= 0 ? '+' : '' }}{{ number_format($compte['variation'], 0, ',', ' ') }} FCFA
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-light border text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                        <h6 class="text-muted mb-0">Aucune donnée disponible pour ce mois</h6>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    <style>
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .icon-box {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
    }
    
    .card {
        transition: all 0.3s ease;
    }
</style>
</div>

