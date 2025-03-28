<div>
    <div class="card shadow-lg p-3 bg-white rounded" id="monPanier"
        style="position: fixed; right: 0; top: 10%; width: 27em; font-size: 12px;">
        
        <!-- Titre du panier -->
        <h6 class="text-center"><strong><u>Mon panier</u></strong></h6>
        
        <!-- Message d'erreur si nécessaire -->
        @if (session('error'))
        <div class="alert alert-danger alert-icon" role="alert">
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-icon-content">
                {{ session('error') }}
            </div>
        </div>
        @endif

        <!-- Tableau des produits -->
        <table class="table table-striped table-hover text-center table-responsive"  style="height: 200px; font-size: xx-small;">
            <thead class="bg-light">
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">P.U</th>
                    <th scope="col">QTE</th>
                    <th scope="col">Total</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                
                @forelse($cart as $produit)
                <tr style="font-size: xx-small;">
                    <td>{{ $produit['name'] }}</td>
                    <td>
                        <span>{{ $produit['prix_achat'] }}</span>
                        <input class="mt-1" placeholder="prix manuel..." type="number" wire:model.lazy="new_price" wire:change="update_prix('{{ $produit['id'] }}')" style="width: 70px;" >
                    </td>
                    <td >
                        <p  style="cursor: pointer;">{{ $produit['quantity'] }}</p>
                        <input type="number" placeholder="Qte..." style="width: 50px;"  wire:model="quantity" value="{{ $produit['quantity'] }}" wire:change="modifierQuantite(' {{$produit['id']}} ')">
                    </td>    
                    <td>{{  (int)$produit['prix_achat'] * $produit['quantity'] }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" wire:click="retirerProduit({{ $produit['id'] }})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Votre panier est vide</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Total du panier -->
        <div class="d-flex justify-content-between p-2 bg-light rounded">
            <strong>Total :</strong>
            <span>{{ $this->panierTotal() }}</span>
        </div>

        <!-- Boutons du panier -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <button type="button" class="btn btn-danger px-3" style="font-size: 12px;" wire:click="viderPanier">
                🗑 Vider le panier
            </button>
            <button type="button" class="btn btn-success px-3" style="font-size: 12px;" data-bs-toggle="modal" data-bs-target="#exampleModal">
                ✅ Valider la vente
            </button>
        </div>
    </div>
</div>
