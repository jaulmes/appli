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
                <label><input type="radio" name="option" value="vente"> Vente de produit</label>
                <label><input type="radio" name="option" value="installation"> Installation</label>
                <label><input type="radio" name="option" value="proformat"> Proformat</label>
            </div>
            
            <!-- Formulaire vente de produit-->
            <livewire:formulaire-vente-produit/>
            
            <!-- Formulaire installation sollaire -->
            <livewire:formulaire-installation-sollaire/>

            <!-- Formulaire installation sollaire -->
            <livewire:formulaire-proformat/>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        </div>
    </div>
</div>
