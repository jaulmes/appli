<div class="container-fluid my-4" style="font-size: 10px;">
    <div class="text-center mb-3">
        <h5 class="text-uppercase fw-bold">Classement des <strong>clients</strong> insolvable</h5>
    </div>

    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="bg-dark text-white" style="position: sticky; top: 0; z-index: 1;">
                <tr class="text-center">
                    <th>Agent Opérant</th>
                    <th>Client</th>
                    <th>Produits et Quantité</th>
                    <th>Coût Total</th>
                    <th>Dernier Versement</th>
                    <th>Prochain Versement</th>
                    <th>Montant Déjà Versé</th>
                    <th>Montant à Remettre</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                {{-- VENTES --}}
                    @foreach($client->ventes as $vente)
                        <tr class="text-center">
                            <td>{{ $vente->user->name ?? 'N/A' }}</td>
                            <td>{{ $client->nom }}</td>
                            <td>
                                @foreach($vente->produits as $produit)
                                    {{ $produit->name }} ({{ $produit->pivot->quantity }})<br>
                                @endforeach
                            </td>
                            <td>{{ number_format($vente->NetAPayer, 0) }} FCFA</td>
                            <td>{{ number_format($vente->montantVerse, 0) }} FCFA</td>
                            <td>{{ $vente->dateLimitePaiement ?? 'N/A' }}</td>
                            <td>{{ number_format($vente->montantVerse, 0) }} FCFA</td>
                            <td>{{ number_format($vente->NetAPayer - $vente->montantVerse, 0) }} FCFA</td>
                        </tr>
                    @endforeach

                    {{-- INSTALLATIONS --}}
                    @foreach($client->installations as $installation)
                        <tr class="text-center">
                            <td>{{ $installation->user->name ?? 'N/A' }}</td>
                            <td>{{ $client->nom }}</td>
                            <td>
                                @foreach($installation->produits as $produit)
                                    {{ $produit->name }} ({{ $produit->pivot->quantity }})<br>
                                @endforeach
                            </td>
                            <td>{{ number_format($installation->NetAPayer, 0) }} FCFA</td>
                            <td>{{ number_format($installation->montantVerse, 0) }} FCFA</td>
                            <td>{{ $installation->dateLimitePaiement ?? 'N/A' }}</td>
                            <td>{{ number_format($installation->montantVerse, 0) }} FCFA</td>
                            <td>{{ number_format($installation->NetAPayer - $installation->montantVerse, 0) }} FCFA</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
