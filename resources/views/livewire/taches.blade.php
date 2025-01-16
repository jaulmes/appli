<div>
    <div class="container mt-5">
        <!-- Sprint Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex gap-2">
                <span class="badge bg-secondary rounded-circle p-2">0</span>
                <span class="badge bg-primary rounded-circle p-2">0</span>
                <span class="badge bg-success rounded-circle p-2">0</span>
            </div>
            <!-- Boutons de filtre -->
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-secondary  active" wire:click="mesTaches()">Mes Taches</button>
                @can('CREER_PRODUIT')
                    <button type="button" class="btn btn-secondary" wire:click="allTaches()" >Toutes les Taches</button>
                @endcan
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Ajouter une Taches
            </button>
        </div>
        <!-- Tickets Section -->
        <ul class="list-group mb-3">
            @foreach($taches as $tache)
                <livewire:tache-item :tache="$tache" :key="$tache->id">
            @endforeach
        </ul>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <livewire:modal-creer-tache>
        </div>
    </div>
</div>