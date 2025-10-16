<div class="modal fade" style="font-size: small;" wire:ignore.self id="deleteAprovisionement-{{$achat->id}}" aria-hidden="true" aria-labelledby="deleteAprovisionementLabel-{{$achat->id}}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-3">
            
            <!-- Header -->
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title d-flex align-items-center" id="deleteAprovisionementLabel-{{$achat->id}}">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Supprimer l'achat
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            
            <!-- Body -->
            <div class="modal-body p-4">
                <!--message d'erreur-->
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss=" alert" aria-label="Close"></button>
                    </div>
                @endif
                <!--fin message d'erreur-->
                <div class="alert alert-warning d-flex align-items-center shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle fa-2x me-3 text-danger"></i>
                    <div>
                        <strong class="d-block">Attention !</strong>
                        Vous êtes sur le point de supprimer définitivement cet achat. <br>
                        Cette action est <span class="fw-bold text-danger">irréversible</span>.
                    </div>
                </div>

                <!-- Motif -->
                <div class="mb-3">
                    <label for="motif-{{$achat->id}}" class="form-label fw-semibold">
                        <i class="fas fa-pen me-2 text-muted"></i> Motif de suppression
                    </label>
                    <textarea 
                        id="motif-{{$achat->id}}" 
                        class="form-control border-2 rounded-2" 
                        placeholder="Entrez le motif de suppression de l'achat..." 
                        rows="3" 
                        wire:model="raison"
                        required>
                    </textarea>
                </div>

                <!-- Boutons -->
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Annuler
                    </button>
                    <button type="button" class="btn btn-danger px-4" wire:click="delete" wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <i class="fas fa-trash-alt me-1"></i> Supprimer
                        </span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            Suppression...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
