<div>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Enregistrement du proformat. <br/> prix des produits: <span class="badge bg-success">{{ $this->montantTotal() }} F cfa</span></h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- Formulaire installation sollaire -->
            <livewire:formulaire-proformat/>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        </div>
    </div>
</div>
