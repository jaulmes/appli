<div>
    <h2>État des comptes - {{ $moisSelectionne }}</h2>

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Compte</th>
                <th class="border px-4 py-2">Montant Initial</th>
                <th class="border px-4 py-2">Montant Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resultats as $etat)
                <tr>
                    <td class="border px-4 py-2">{{ $etat['compte'] }}</td>
                    <td class="border px-4 py-2">{{ number_format($etat['montant_initial'], 0, ',', ' ') }} FCFA</td>
                    <td class="border px-4 py-2">{{ number_format($etat['montant_final'], 0, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
