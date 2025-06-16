<div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enregistrement de la commande</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="enregistrerBonCommande">
                        <div class="row">
                            <!-- Titre de la commande -->
                            <div class="form-group col-md-12">
                                <label for="titre">Titre de la commande</label>
                                <input wire:model="titre" class="form-control" type="text" name="titre" id="titre" required>
                            </div>

                            <!-- Compte (mode de paiement) -->
                            <div class="form-group col-md-6">
                                <label for="compte_id">Mode de paiement</label>
                                <select wire:model="compte_id" class="form-control" name="compte_id" required>
                                    <option selected >Choisir un mode</option>
                                    @foreach($comptes as $compte)
                                    <option value="{{$compte->id}}">{{$compte->nom}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Montant total -->
                            <div class="form-group col-md-6">
                                <label for="montant">Montant total</label>
                                <input wire:model="montant" class="form-control" type="number" name="montant" id="montant" value="{{ $this->updateCart() }}" readonly>
                            </div>

                            <!-- Frais supplémentaires -->
                            <div class="form-group col-md-6">
                                <label for="frais">Frais supplémentaires (optionnel)</label>
                                <input wire:model="frais" class="form-control" type="number" name="frais" id="frais" min="0" value="0">
                            </div>

                            <!-- Date de commande -->
                            <div class="form-group col-md-6">
                                <label for="date_commande">Date de commande</label>
                                <input wire:model="date_commande" class="form-control" type="date" name="date_commande" id="date_commande" required>
                            </div>

                            <!-- Date de livraison -->
                            <div class="form-group col-md-6">
                                <label for="date_livraison">Date de livraison prévue</label>
                                <input wire:model="date_livraison" class="form-control" type="date" name="date_livraison" id="date_livraison" required>
                            </div>
                        </div>
                
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Enregistrer la commande</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>