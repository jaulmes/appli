<div>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Enregistrement de la transaction. prix des produits: {{ Cart::getTotal() }} F cfa</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row" style="display: flex; flex-direction:column">
                <label><input type="radio" name="option" value="yes"> Vente de produit</label>
                <label><input type="radio" name="option" value="no"> Installation</label>
            </div>
            
            <!-- Formulaire vente de produit-->
            <livewire:formulaire-vente-produit/>
            
            <!-- Formulaire installation sollaire -->
            <livewire:formulaire-installation-sollaire/>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        </div>
    </div>
</div>
