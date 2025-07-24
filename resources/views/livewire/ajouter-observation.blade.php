<div class="modal fade" wire:ignore.self id="ajouterObservationModal-{{$suivi->id}}" tabindex="-1" aria-labelledby="observationModalLabel-{{$suivi->id}}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h1 class="modal-title fs-5" id="observationModalLabel-{{$suivi->id}}">
          <i class="fas fa-comment-medical me-2"></i>Ajouter une observation - Suivi de {{$suivi->clients->nom}}
        </h1>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      
      <div class="modal-body">
          <div class="mb-3">
            <label for="resume-{{$suivi->id}}" class="form-label fw-bold">
              <i class="fas fa-comment-dots me-1"></i>Résumé de la discussion <span class="text-danger">*</span>
            </label>
            <textarea class="form-control shadow-sm" 
                     id="resume-{{$suivi->id}}" 
                     wire:model="resume" 
                     rows="5" 
                     placeholder="Décrivez en détail l'échange avec le client..."
                     required></textarea>
          </div>

            <!-- Section Besoins - Améliorée -->
            <div class="card mb-4 border-success">
                <div class="card-header bg-light-success">
                    <h6 class="mb-0 text-success fw-semibold">
                        <i class="fas fa-lightbulb me-2"></i>Besoins du Client <span class="text-danger">*</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div id="besoins-container-{{$suivi->id}}">
                        @foreach($besoins as $index => $besoin)
                            <div class="input-group mb-3" id="besoin-{{ $index }}">
                                <span class="input-group-text bg-success text-white">{{ $index + 1 }}</span>
                                <input type="text" class="form-control" wire:model="besoins.{{ $index }}.title" placeholder="Décrire le besoin précis du client">
                                <button type="button" class="btn btn-outline-danger" wire:click="removeBesoin({{ $index }})" title="Supprimer">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="addBesoin-{{$suivi->id}}" class="btn btn-success mt-2" wire:click="addBesoin">
                        <i class="fas fa-plus-circle me-1"></i>Ajouter un besoin
                    </button>
                </div>
            </div>
          
          <div class="row g-3">
            <div class="col-md-6">
              <label for="prochain_rendez_vous-{{$suivi->id}}" class="form-label fw-bold">
                <i class="far fa-calendar-alt me-1"></i>Prochain rendez-vous
              </label>
              <input type="date" 
                     class="form-control shadow-sm" 
                     wire:model="prochain_rendez_vous" 
                     id="prochain_rendez_vous-{{$suivi->id}}" 
                     min="{{ now()->format('Y-m-d') }}">
              <div class="form-text">Optionnel</div>
            </div>
            
            <div class="col-md-6">
              <label for="conclusion-{{$suivi->id}}" class="form-label fw-bold">
                <i class="fas fa-calendar-check me-1"></i>Date installation
              </label>
              <input type="date" 
                     class="form-control shadow-sm" 
                     wire:model="conclusion" 
                     id="conclusion-{{$suivi->id}}" 
                     min="{{ now()->format('Y-m-d') }}">
              <div class="form-text">Si définie</div>
            </div>
          </div>
      </div>
      
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times me-1"></i>Annuler
        </button>
        <button type="button" class="btn btn-success" wire:click="saveObservation({{$suivi->id}})" wire:loading.attr="disabled">
          <i class="fas fa-save me-1"></i>Enregistrer
        </button>
      </div>
    </div>
  </div>
</div>