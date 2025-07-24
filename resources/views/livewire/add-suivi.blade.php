<div class="modal-dialog modal-lg">
    <!-- messages d'erreur -->
    @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erreur !</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="modal-content border-0 shadow">
        <!-- En-tête amélioré -->
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title fs-5" id="exampleModalLabel">
                <i class="fas fa-clipboard-list me-2"></i>Nouveau Suivi Client
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>

        <!-- Corps de modal réorganisé -->
        <div class="modal-body p-4">
            <!-- Section Client - Améliorée -->
            <div class="card mb-4 border-primary">
                <div class="card-header bg-light-primary d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-primary fw-semibold">
                        <i class="fas fa-user-circle me-2"></i>Références Client <span class="text-danger">*</span>
                    </h6>
                    <button type="button" class="btn btn-sm {{ $nouveau_client ? 'btn-outline-primary' : 'btn-primary' }}" wire:click="handle_client">
                        <i class="fas {{ $nouveau_client ? 'fa-users' : 'fa-user-plus' }} me-1"></i>
                        {{ $nouveau_client ? 'Client existant' : 'Nouveau client' }}
                    </button>
                </div>
                <div class="card-body">
                    @if(!$nouveau_client)
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="client_id" class="form-label fw-medium">Sélectionnez un client</label>
                                <select class="form-select"  wire:model="client_id" >
                                    <option value="">Choisir un client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->nom }} - {{ $client->numero }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @else
                        <div class="row g-3">
                            <h6 class="text-muted mb-3"><i class="fas fa-info-circle me-2"></i>Informations du nouveau client</h6>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Nom complet</label>
                                <input type="text" class="form-control" wire:model="nom_nouveau_client" placeholder="Jean Dupont">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Téléphone</label>
                                <div class="input-group">
                                    <span class="input-group-text">+237</span>
                                    <input type="tel" class="form-control" wire:model="numero_nouveau_client" placeholder="658000000">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Email</label>
                                <input type="email" class="form-control" wire:model="email_nouveau_client" placeholder="email@exemple.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Adresse</label>
                                <input type="text" class="form-control" wire:model="adresse_client" placeholder="pk8, douala">
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section Besoins - Améliorée -->
            <div class="card mb-4 border-success">
                <div class="card-header bg-light-success">
                    <h6 class="mb-0 text-success fw-semibold">
                        <i class="fas fa-lightbulb me-2"></i>Besoins du Client <span class="text-danger">*</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div id="besoins-container">
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
                    <button type="button" class="btn btn-success mt-2" wire:click="addBesoin">
                        <i class="fas fa-plus-circle me-1"></i>Ajouter un besoin
                    </button>
                </div>
            </div>

            <!-- Section Observation - Améliorée -->
            <div class="card mb-4 border-info">
                <div class="card-header bg-light-info">
                    <h6 class="mb-0 text-info fw-semibold">
                        <i class="fas fa-eye me-2"></i>Observation <span class="text-danger">*</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-medium">Notes détaillées</label>
                            <textarea class="form-control" wire:model="resume" rows="3" placeholder="Décrire l'échange avec le client, ses attentes..."></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Prochain contact</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                <input type="datetime-local" class="form-control" wire:model="prochain_rendez_vous">
                            </div>
                            <small class="text-muted">Date et heure du prochain rendez-vous</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Conclusion - Améliorée -->
            <div class="card border-warning">
                <div class="card-header bg-light-warning">
                    <h6 class="mb-0 text-warning fw-semibold">
                        <i class="fas fa-check-circle me-2"></i>Conclusion
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Date d'installation confirmée</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                <input type="date" class="form-control" wire:model="date_conclusion">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pied de page amélioré -->
        <div class="modal-footer bg-light d-flex justify-content-between">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                <i class="fas fa-times-circle me-1"></i>Annuler
            </button>
            <div>
                <span class="text-muted me-3 d-none d-md-inline">Tous les champs marqués <span class="text-danger">*</span> sont obligatoires</span>
                <button type="button" class="btn btn-primary px-4" wire:click="saveSuivi()" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="saveSuivi">
                        <i class="fas fa-save me-1"></i>Enregistrer
                    </span>
                    <span wire:loading wire:target="saveSuivi">
                        <i class="fas fa-spinner fa-spin me-1"></i>Enregistrement...
                    </span>
                </button>
            </div>
        </div>
    </div>
    <style>
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .bg-light-primary {
        background-color: rgba(13,110,253,0.1);
    }
    .bg-light-success {
        background-color: rgba(25,135,84,0.1);
    }
    .bg-light-info {
        background-color: rgba(13,202,240,0.1);
    }
    .bg-light-warning {
        background-color: rgba(255,193,7,0.1);
    }
    .form-control, .form-select, .input-group-text {
        border-radius: 6px;
    }
    .select2 {
        width: 100% !important;
    }
</style>


</div>

