<div>
    <h2 class="text-xl font-bold mb-4">État des comptes - {{ $moisSelectionne }}</h2>

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Compte</th>
                <th class="border px-4 py-2">Mois</th>
                <th class="border px-4 py-2">Montant initial</th>
                <th class="border px-4 py-2">Montant final</th>
                <th class="border px-4 py-2">Variation</th>
            </tr>
        </thead>
        <tbody>
            @forelse($resultats as $res)
                <tr>
                    <td class="border px-4 py-2">{{ $res['compte'] }}</td>
                    <td class="border px-4 py-2">{{ $res['mois'] }}</td>
                    <td class="border px-4 py-2 text-green-600">{{ number_format($res['montant_initial'], 0, ',', ' ') }} FCFA</td>
                    <td class="border px-4 py-2 text-blue-600">{{ number_format($res['montant_final'], 0, ',', ' ') }} FCFA</td>
                    <td class="border px-4 py-2 {{ $res['variation'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($res['variation'], 0, ',', ' ') }} FCFA
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="border px-4 py-2 text-center text-gray-500">
                        Aucun résultat disponible pour ce mois
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
