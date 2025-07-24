<div class="container-fluid my-4" style="font-size: 14px;">
    <div class="text-center mb-4">
        <h4 class="text-uppercase fw-bold text-primary">
            <i class="fas fa-money-bill-wave me-2"></i>Classement des <strong>charges</strong> du mois
        </h4>
    </div>

    <div class="table-responsive rounded shadow-sm" style="max-height: 500px; overflow-y: auto;">
        <table class="table table-hover align-middle table-bordered bg-white">
            <thead class="bg-primary text-white sticky-top">
                <tr class="text-center">
                    <th><i class="fas fa-receipt me-1"></i> Intitulé</th>
                    <th><i class="fas fa-calendar-alt me-1"></i> Date</th>
                    <th><i class="fas fa-coins me-1"></i> Montant (FCFA)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($charges as $charge)
                    <tr class="text-center">
                        <td>{{ $charge->titre }}</td>
                        <td>{{ \Carbon\Carbon::parse($charge->date)->locale('fr_FR')->isoFormat('D MMM YYYY') }}</td>
                        <td class="text-danger fw-bold">{{ number_format($charge->montant, 0, ',', ' ') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            <i class="fas fa-info-circle me-2"></i>Aucune charge enregistrée pour ce mois.
                        </td>
                    </tr>
                @endforelse

                @if ($charges->count())
                    <tr class="bg-light text-center fw-bold border-top">
                        <td colspan="2">Total des charges</td>
                        <td class="text-danger">{{ number_format($total, 0, ',', ' ') }} FCFA</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
