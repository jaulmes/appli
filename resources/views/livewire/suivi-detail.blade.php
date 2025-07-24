<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight-{{$suivi->id}}" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header bg-light">
        <div>
            <h5 class="offcanvas-title text-primary mb-1" id="offcanvasRightLabel">
                <i class="fas fa-info-circle me-2"></i>Détails du suivi client
            </h5>
            <div class="text-muted small">Dernière mise à jour: {{ now()->format('d/m/Y') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Section Client -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                        <i class="fas fa-user text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">👤 {{ $suivi->clients->nom }}</h6>
                        <span class="text-muted small">
                            📞 {{ $suivi->clients->numero }}
                        </span>
                    </div>
                </div>
                <div class="d-flex justify-content-between small">
                    <span class="text-muted">
                        <i class="far fa-calendar me-1"></i>Suivi depuis {{ $suivi->created_at->format('m/Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Section Détails -->
        <div class="mb-4">
            <h5 class="d-flex align-items-center mb-3">
                <span class="bg-primary bg-opacity-10 p-2 rounded me-2">
                    <i class="fas fa-clipboard-list text-primary"></i>
                </span>
                <span>Détails du suivi</span>
            </h5>
            
            <div class="ps-4">
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Besoins du client</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($suivi->besoins->pluck('titre') as $besoin)
                            <span class="badge bg-primary bg-opacity-25 text-primary">{{ $besoin }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Historique des observations</label>
                    <div class="list-group list-group-flush">
                        @foreach($suivi->observations as $index => $observation)
                            <div class="list-group-item border-0 px-0 py-2">
                                <div class="d-flex">
                                    <span class="badge bg-secondary me-2">{{ $index + 1 }}</span>
                                    <div>
                                        <p class="mb-1">{{ $observation->resume }}</p>
                                        <small class="text-muted">
                                            <i class="far fa-clock me-1"></i>
                                            {{ $observation->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small mb-1">Prochain rendez-vous</label>
                        <div class="d-flex align-items-center">
                            <i class="far fa-calendar-check text-warning me-2"></i>
                            <span class="text-warning">{{$suivi->prochain_rendez_vous ?? 'Non défini'}}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small mb-1">Date installation</label>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar-day text-success me-2"></i>
                            <span class="text-success">{{ $suivi->conclusion ?? 'Non définie' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <livewire:modal-voir-activite-client :client="$suivi->clients" :key="$suivi->clients->id"/>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterObservationModal-{{$suivi->id}}">
                <i class="fas fa-plus me-1"></i> Nouvelle observation
            </button>
            <livewire:ajouter-observation :suivi="$suivi" />

        </div>
    </div>
</div>