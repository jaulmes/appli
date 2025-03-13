<div>
    <div  class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Choisir les produits pour faire la promo</h1><br>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead class="thead-dark fixed">
                            <tr>
                                <th>Nom du Produit</th>
                                <th>Prix</th>
                                <th>Prix Promo</th>
                                <th>Promotionnel</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produit_non_promo as $produit)
                                <tr>
                                    <td style="font-size: x-small;">{{ $produit->name }}</td>
                                    <td style="font-size: x-small;">{{ $produit->getPrice() }} </td>
                                    @if($produit->prix_promo)
                                        <td style="font-size: x-small;">{{ $produit->prix_promo }} fcfa</td>
                                    @else
                                        <td style="font-size: x-small;"> <input type="number" class="form-control" placeholder="prix promo" wire:model="prix_promo.{{ $produit->id }}" wire:key="promo-price-input-{{ $produit->id }}"> </td>
                                    @endif
                                    <td style="font-size: x-small;">
                                        <input type="checkbox" wire:model="produit_selectionne" wire:key="promo-checkbox-{{ $produit->id }}" value="{{ $produit->id }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="submit()">valider</button>
                </div>
            </div>
        </div>
    </div>
</div>
