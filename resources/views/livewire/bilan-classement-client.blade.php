<div>
<h1>Classement des meilleurs clients</h1>

<table id="clientsTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nom du client</th>
            <th>Transactions</th>
            <th>Bénéfice Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalBenefice = 0;
        @endphp

        @foreach($clients as $client)
            @php
                $beneficeClient = 0;
                $hasTransactions = !$client->ventes->isEmpty() || !$client->installations->isEmpty();
            @endphp

            @if($hasTransactions)
                <tr>
                    <td>
                        <strong>{{ $client->nom }}</strong><br>
                        {{ $client->numero }}
                    </td>
                    <td>
                        <div class="table-responsive">
                            <table class="table-details">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Produit</th>
                                        <th>Qté</th>
                                        <th>Prix Achat U.</th>
                                        <th>Total Achat</th>
                                        <th>Prix Vente U.</th>
                                        <th>Total Vente</th>
                                        <th>Bénéfice</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Ventes -->
                                    @foreach($client->ventes as $vente)
                                        @foreach($vente->produits as $produit)
                                            @php
                                                $quantite = $produit->pivot->quantity;
                                                $achatUnitaire = $produit->prix_achat;
                                                $venteUnitaire = $produit->pivot->price;
                                                $totalAchat = $achatUnitaire * $quantite;
                                                $totalVente = $venteUnitaire * $quantite;
                                                $benefice = $totalVente - $totalAchat;
                                                
                                                $beneficeClient += $benefice;
                                                $totalBenefice += $benefice;
                                            @endphp
                                            <tr>
                                                <td>Vente</td>
                                                <td>{{ $produit->name }}</td>
                                                <td>{{ $quantite }}</td>
                                                <td>{{ number_format($achatUnitaire, 2) }}</td>
                                                <td>{{ number_format($totalAchat, 2) }}</td>
                                                <td>{{ number_format($venteUnitaire, 2) }}</td>
                                                <td>{{ number_format($totalVente, 2) }}</td>
                                                <td>{{ number_format($benefice, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach

                                    <!-- Installations -->
                                    @foreach($client->installations as $installation)
                                        @foreach($installation->produits as $produit)
                                            @php
                                                $quantite = $produit->pivot->quantity;
                                                $achatUnitaire = $produit->prix_achat;
                                                $venteUnitaire = $produit->pivot->price;
                                                $totalAchat = $achatUnitaire * $quantite;
                                                $totalVente = $venteUnitaire * $quantite;
                                                $benefice = $totalVente - $totalAchat;
                                                
                                                $beneficeClient += $benefice;
                                                $totalBenefice += $benefice;
                                            @endphp
                                            <tr>
                                                <td>Installation</td>
                                                <td>{{ $produit->name }}</td>
                                                <td>{{ $quantite }}</td>
                                                <td>{{ number_format($achatUnitaire, 2) }}</td>
                                                <td>{{ number_format($totalAchat, 2) }}</td>
                                                <td>{{ number_format($venteUnitaire, 2) }}</td>
                                                <td>{{ number_format($totalVente, 2) }}</td>
                                                <td>{{ number_format($benefice, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td class="text-bold">{{ number_format($beneficeClient, 2) }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" class="text-right"><strong>Bénéfice Total Généré :</strong></td>
            <td class="text-bold">{{ number_format($totalBenefice, 2) }}</td>
        </tr>
    </tfoot>
</table>

<style>
    .table-details {
        width: 100%;
        font-size: 0.8em;
        border-collapse: collapse;
    }
    .table-details th, 
    .table-details td {
        padding: 4px;
        border: 1px solid #ddd;
    }
    .table-responsive {
        max-height: 300px;
        overflow-y: auto;
    }
    .text-bold {
        font-weight: bold;
    }
    .text-right {
        text-align: right;
    }
</style>
</div>

