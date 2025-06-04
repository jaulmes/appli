        <table id="example1" class="table table-bordered table-striped" style="font-size: 8px;">
            <thead>
                <tr>
                    <th>Nom du client</th>
                    <th>Produits</th>
                    <th>Bénefices Total</th>
                </tr>
            </thead>
            <tbody >
                @php
                    $totalBenefice = 0;
                @endphp
                @foreach($clients as $client)
                    @if(!$client->ventes->isEmpty())
                        @php 
                            $beneficeClient = 0;
                        @endphp
                        <tr>
                            <td>
                                {{ $client->nom }} <br> {{ $client->numero }}
                            </td>
                            <td>
                                <table border="1" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Produit</th>
                                            <th>Quantité</th>
                                            <th>Prix d'achat Unitaire</th>
                                            <th>Prix d'Achat Total</th>
                                            <th>Prix de Vente Unitaire</th>
                                            <th>Prix de Vente Total</th>
                                            <th>Bénéfices</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($client->ventes as $vente)
                                            @foreach($vente->produits as $produit)
                                                @php
                                                    $beneficeVente = ($produit->pivot->price * $produit->pivot->quantity) - ($produit->prix_achat * $produit->pivot->quantity);
                                                    $beneficeClient = $beneficeClient + $beneficeVente;
                                                    $totalBenefice += $beneficeVente;
                                                @endphp
                                                <tr>
                                                    <td>{{ $produit->name }}</td>
                                                    <td>{{ $produit->pivot->quantity }}</td>
                                                    <td>{{ $produit->prix_achat }}</td>
                                                    <td>{{ $produit->prix_achat * $produit->pivot->quantity }}</td>
                                                    <td>{{ $produit->pivot->price }}</td>
                                                    <td>{{ $produit->pivot->price * $produit->pivot->quantity }}</td>
                                                    <td>{{ $beneficeVente}}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                {{ $beneficeClient }}
                            </td>
                        </tr>
                    @endif
                    @if(!$client->installations->isEmpty())
                        <tr>
                            <td>
                                {{ $client->nom }} <br> {{ $client->numero }}
                            </td>
                            <td>
                                <table border="1" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Produit</th>
                                            <th>Quantité</th>
                                            <th>Prix d'achat Unitaire</th>
                                            <th>Prix d'Achat Total</th>
                                            <th>Prix de Vente Unitaire</th>
                                            <th>Prix de Vente Total</th>
                                            <th>Bénéfices</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($client->installations as $installation)
                                            @foreach($installation->produits as $produit)
                                                @php
                                                    $beneficeVente = ($produit->pivot->price * $produit->pivot->quantity) - ($produit->prix_achat * $produit->pivot->quantity);
                                                    $totalBenefice += $beneficeVente;
                                                @endphp
                                                <tr>
                                                    <td>{{ $produit->name }}</td>
                                                    <td>{{ $produit->pivot->quantity }}</td>
                                                    <td>{{ $produit->prix_achat }}</td>
                                                    <td>{{ $produit->prix_achat * $produit->pivot->quantity }}</td>
                                                    <td>{{ $produit->pivot->price }}</td>
                                                    <td>{{ $produit->pivot->price * $produit->pivot->quantity }}</td>
                                                    <td>{{ $beneficeVente}}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                {{$totalBenefice}}
                            </td>
                        </tr>
                    @endif
                @endforeach
                
            </tbody>

        </table>