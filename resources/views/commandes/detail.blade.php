@extends('dashboard.main')

@section('content')
<div class="container">
    <h2>Détails de la commande #{{ $commande->id }}</h2>

    <div class="card mb-4">
        <div class="card-header">Informations du client</div>
        <div class="card-body">
            <p><strong>Nom :</strong> {{ $commande->clients->nom }}</p>
            <p><strong>Numéro :</strong> {{ $commande->clients->numero }}</p>
            <p><strong>Email :</strong> {{ $commande->clients->email }}</p>
            <p><strong>Adresse :</strong> {{ $commande->clients->adresse }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Produits commandés</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commande->produits as $produit)
                        <tr>
                            <td>{{ $produit->name }}</td>
                            <td>{{ $produit->pivot->quantity }}</td>
                            <td>{{ number_format($produit->pivot->price, 0, ',', ' ') }} FCFA</td>
                            <td>{{ number_format($produit->pivot->quantity * $produit->pivot->price, 0, ',', ' ') }} FCFA</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Valider la commande
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <livewire:modal-valider-commande :commandeId="$commande->id"/>
                                </div>
                            </div>
                        </th>
                        <th colspan="2" class="text-end">Montant total :</th>
                        <th>{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
