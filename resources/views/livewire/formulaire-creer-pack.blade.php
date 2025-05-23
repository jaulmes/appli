<div class="container py-1" style="max-width: 800px;" >
    <!-- Titre -->
    <div class="mb-1">
        <label for="title" class="form-label fw-bold text-primary">Titre *</label>
        <input
            type="text"
            class="form-control rounded-3"
            id="title"
            wire:model='titre'
            placeholder="Entrez un titre descriptif"
            required>
    </div>

    <!-- Description -->
    <div class="mb-1">
        <label for="description" class="form-label fw-bold text-primary">Description *</label>
        <textarea
            class="form-control rounded-3"
            id="description"
            wire:model='description'
            rows="3"
            placeholder="Décrivez en détail..."
            required>
        </textarea>
    </div>

    <!-- Upload d’image -->
    <div class="mb-1">
        <label for="image" class="form-label fw-bold text-primary">Image *</label>
        <div class="card rounded-3">
            <div class="card-body text-center">
                <input
                    class="form-control d-none"
                    type="file"
                    id="image"
                    wire:model='image'
                    required
                    >
                <label for="image" class="btn btn-outline-primary">
                    <i class="fas fa-cloud-upload-alt me-2"></i>
                    Choisir un fichier
                </label>
                @if($image)
                    <img
                        src="{{ $image->temporaryUrl() }}"
                        class="img-fluid mt-1 rounded"
                        alt="Aperçu de l'image"
                        style="max-height: 300px;">
                @endif
            </div>
        </div>
    </div>

    <!-- Boutons -->
    <div class="d-flex justify-content-end gap-2 mt-1">

        <button type="submit" class="btn btn-success rounded-pill px-4" wire:click="enregistrer_pack">
            <i class="fas fa-paper-plane me-2"></i>Enregistrer
        </button>
    </div>
    
    
</div>