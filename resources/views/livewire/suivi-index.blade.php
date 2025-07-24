<div class="container-fluid py-3">
    
    {{-- En-tête --}}
    <div class="row mb-4">
        <div class="col-md-8">
            <h3 class="fw-bold mb-0">
                <i class="fas fa-user-friends me-2 text-primary"></i>Suivi des Clients
            </h3>
            <small class="text-muted">Gestion et historique des interactions avec les clients</small>
        </div>
        <div class="col-md-4 text-end">
            <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#suiviModal">
                <i class="fas fa-plus me-1"></i> Nouveau Suivi
            </button>
        </div>
    </div>

    {{-- Modal d’ajout --}}
    <div class="modal fade" id="suiviModal" tabindex="-1" aria-labelledby="suiviModalLabel" aria-hidden="true">
        <livewire:add-suivi/>
    </div>

    {{-- Carte principale --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-list-ul me-2 text-success"></i>Historique des Suivis
            </h5>
            <div class="d-flex flex-wrap gap-2">
                @can('VOIR_PERMISSION')
                    <button class="btn btn-sm {{ $filtreActif === 'tous' ? 'btn-secondary active' : 'btn-outline-secondary' }}" 
                            wire:click="getAllSuivis()">
                        Tous les suivis
                    </button>
                @endcan

                <button class="btn btn-sm {{ $filtreActif === 'mes' ? 'btn-secondary active' : 'btn-outline-secondary' }}" 
                        wire:click="mesSuivis()">
                    Mes suivis
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Client</th>
                            <th>Besoins</th>
                            <th>Observations</th>
                            <th>Conclusion</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suivis as $suivi)
                            <tr class="text-center">
                                {{-- Client --}}
                                <td class="text-start">
                                    <strong>{{ $suivi->clients->nom }}</strong><br>
                                    <small class="text-muted">{{ $suivi->clients->numero }}</small>
                                </td>

                                {{-- Besoins --}}
                                <td>
                                    @foreach($suivi->besoins as $besoin)
                                        <span class="badge bg-info mb-1">{{ $besoin->titre }}</span><br>
                                    @endforeach
                                </td>

                                {{-- Observations --}}
                                <td>
                                    @foreach($suivi->observations as $observation)
                                        <span class="badge bg-warning text-dark mb-1">{{ $observation->resume }}</span><br>
                                    @endforeach
                                </td>

                                {{-- Conclusion --}}
                                <td class="text-muted fst-italic">{{$suivi->conclusion?? 'À compléter'}}</td>

                                {{-- Actions --}}
                                <td>
                                    <div class="btn-group" role="group">
                                        {{-- Voir --}}
                                        <button class="btn btn-outline-primary btn-sm" title="Voir en détail" type="button"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight-{{$suivi->id}}" aria-controls="offcanvasRight">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        {{-- Détails Livewire --}}
                                        <livewire:suivi-detail :suivi="$suivi" />

                                        {{-- Supprimer --}}
                                        <button class="btn btn-outline-danger btn-sm" wire:click="supprimer({{$suivi->id}})" title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Aucun suivi disponible pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if(session()->has('message'))
        <div aria-live="polite" aria-atomic="true" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
            <div class="toast align-items-center text-white bg-success border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('message') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
                </div>
            </div>
        </div>
    @endif
    @if(session()->has('suppression'))
        <div aria-live="polite" aria-atomic="true" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
            <div class="toast align-items-center text-white bg-secondary border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ session('suppression') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
                </div>
            </div>
        </div>
    @endif
    @if(session()->has('error'))
        <div aria-live="polite" aria-atomic="true" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
            <div class="toast align-items-center text-white bg-danger border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
                </div>
            </div>
        </div>
    @endif
</div>
