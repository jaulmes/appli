<div class="modal fade" id="modifier-{{ $produit->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modifierLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" >
                <h1 class="modal-title fs-5" id="modifierLabel">Modifier les details de promotion</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <table>
                        <thead>
                            <th >Nom du produit</th>
                            <th >Prix catalogue</th>
                            <th >Prix Promo</th>
                            <th >Position catalogue</th>
                            <th >Position Web</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$produit->name}}</td>
                                <td>{{$produit->price}}</td>
                                <td>{{$produit->prix_promo}}</td>
                                <td>{{$produit->position_catalogue?? '?'.'/'.$produits->count()}}</td>
                                <td>{{$produit->position_promo?? '?'.'/'.$produit_promo->count()}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <span style="color: red;">*</span>Position Promo: <input wire:model="position_promo" type="number" class="form-control" placeholder="Position d'affichage">
                    </div>
                    <div>
                        <span style="color: red;">*</span>Position Catalogue: <input wire:model="position_catalogue" type="number" class="form-control" placeholder="Position d'affichage">
                    </div>
                    <div>
                        Prix promo: <input wire:model="prix_promo" type="number" class="form-control" placeholder="Prix promo" >
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" wire:click="validerModification()">valider</button>
            </div>
        </div>
    </div>
</div>