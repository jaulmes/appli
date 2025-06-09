<div style="font-size: 12px; text-align: center;" class="table-primary">
    <h6>Classement des <strong>Produits</strong> vendus</h6>

    <div style="max-height: 400px; overflow-y: auto;">
        <table class="table table-bordered table-striped" style="width: 100%;">
            <thead class="bg-primary text-white" style="position: sticky; top: 0; z-index: 1;">
                <tr>
                    <th>Produit</th>
                    <th>Nombre de vente</th>
                    <th>P. Achat Unitaire</th>
                    <th>P. Achat Total</th>
                    <th>P. Vente Total</th>
                    <th>Bénéfice</th>
                    <th>Chiffre d'affaire</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalBenefice = 0;
                    $totalChiffreAffaire = 0;
                    $totalAchat = 0;
                    $totalVente = 0;
                @endphp

                @foreach($produits as $produit)
                    @php
                        $nombreVendu = 0;
                        $achatTotal = 0;
                        $venteTotal = 0;
                        $mainOeuvre =0; 
                    @endphp

                    @foreach($produit->ventes as $vente)
                        @php
                            $qty = $vente->pivot->quantity;
                            $price = $vente->pivot->price;

                            $nombreVendu += $qty;
                            $venteTotal += $qty * $price;
                            $achatTotal += $qty * $produit->prix_achat;
                        @endphp
                    @endforeach

                    @foreach($produit->installations as $installation)
                        @php
                            $qty = $installation->pivot->quantity;
                            $price = $installation->pivot->price;

                            $nombreVendu += $qty;
                            $venteTotal += $qty * $price;
                            $achatTotal += $qty * $produit->prix_achat;
                        @endphp
                    @endforeach

                    @php
                        $benefice = $venteTotal - $achatTotal;
                        $chiffreAffaire = $venteTotal ;

                        $totalAchat += $achatTotal;
                        $totalVente += $venteTotal;
                        $totalBenefice += $benefice;
                        $totalChiffreAffaire += $chiffreAffaire;
                    @endphp

                    <tr>
                        <td>{{ $produit->name }}</td>
                        <td>{{ $nombreVendu }}</td>
                        <td>{{ number_format($produit->prix_achat, 2) }} FCFA</td>
                        <td>{{ number_format($achatTotal, 2) }} FCFA</td>
                        <td>{{ number_format($venteTotal, 2) }} FCFA</td>
                        <td>{{ number_format($benefice, 2) }} FCFA</td>
                        <td>{{ number_format($chiffreAffaire, 2) }} FCFA</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-light font-weight-bold">
                <tr>
                    <td colspan="3">Totaux</td>
                    <td>{{ number_format($totalAchat, 2) }} FCFA</td>
                    <td>{{ number_format($totalVente, 2) }} FCFA</td>
                    <td>{{ number_format($totalBenefice, 2) }} FCFA</td>
                    <td>{{ number_format($totalChiffreAffaire, 2) }} FCFA</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
