<div class="container my-3">
    <div class="text-center mb-2">
        <h4 class="fw-bold text-uppercase text-primary">
            Bilan Financier - {{ \Carbon\Carbon::parse($moisSelectionne)->translatedFormat('F Y') }}
        </h4>
        <p class="text-muted">Résumé des bénéfices, charges et investissements pour ce mois</p>
    </div>

    <div class="row g-4 justify-content-center">
        <!-- Carte -->
        @php
            $cards = [
                ['icon' => 'bi-currency-dollar', 'label' => 'Chiffre d\'Affaires', 'value' => $chiffreAffaire, 'color' => 'info'],
                ['icon' => 'bi-cash-coin', 'label' => 'Bénéfice Brut', 'value' => $beneficeBrute, 'color' => 'success'],
                ['icon' => 'bi-receipt', 'label' => 'Total des Charges', 'value' => $totalCharge, 'color' => 'danger'],
                ['icon' => 'bi-graph-up-arrow', 'label' => 'Bénéfice Réel', 'value' => $beneficeReele, 'color' => 'primary'],
                ['icon' => 'bi-piggy-bank', 'label' => 'Montant Investi', 'value' => $montantInvesti, 'color' => 'warning'],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="col-md-2">
                <div class="card shadow border-0 h-100">
                    <div class="card-body text-center">
                        <i class="bi {{ $card['icon'] }} text-{{ $card['color'] }} fs-1 mb-3"></i>
                        <h6 class="text-muted">{{ $card['label'] }}</h6>
                        <h5 class="fw-bold text-{{ $card['color'] }}">
                            {{ number_format($card['value'], 0, ',', ' ') }} FCFA
                        </h5>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
