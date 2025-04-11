<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Valider commande</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="reduction" class="form-label">Réduction (en FCFA)</label>
            <input type="number" wire:model="reduction" id="reduction" class="form-control" placeholder="Ex: 2000">
        </div>

        <div class="mb-3">
            <label for="montant_verse" class="form-label">Montant versé</label>
            <input type="number" wire:model="montantVerse" id="montant_verse" class="form-control" placeholder="Ex: 15000">
        </div>

        <div class="mb-3">
            <label for="date_limite" class="form-label">Date limite de paiement</label>
            <input type="date" wire:model="dateLimitePaiement" id="date_limite" class="form-control">
        </div>

        <div class="mb-3">
            <label for="mode_paiement" class="form-label">Mode de paiement</label>
            <select wire:model="compte_id" id="mode_paiement" class="form-select" required>
                <option selected>Choisir un compte...</option>
                @foreach($comptes as $compte)
                    <option value="{{ $compte->id }}">{{ $compte->nom }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuller</button>
        <button type="button" class="btn btn-primary" wire:click="validerCommande()">Valider</button>
    </div>
</div>