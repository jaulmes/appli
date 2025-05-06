<div class="card shadow-lg border-0 rounded-lg mb-5">

    {{-- Card header --}}
    <div class="card-header bg-white border-0 py-3">
        <h5 class="mb-0 text-primary">
            <i class="fas fa-file-invoice-dollar me-2"></i>Détails de l'annonce
        </h5>
    </div>

    <div class="card-body p-4">
        <div class="row g-4">
            <div class="form-floating col py-5">
                <input type="file"
                    class="form-control @error('image') is-invalid @enderror"
                    id="image"
                    wire:model="image"
                    required>
                <label for="image">Image<span class="text-danger">*</span></label>
                <span class="position-absolute top-50 end-0 translate-middle-y pe-3 text-muted">
                    <i class="fas fa-image"></i>
                </span>
            </div>
            @if($image)
                <div class="row-md-6">
                    <img src="{{ $image->temporaryUrl() }}" style="width: 150px; height: 150px" alt="Image Preview" class="img-fluid rounded">
                </div>
            @endif
        </div>
        <div class="row">
            <label for="">Liaison de l'annonce </label>
            <div class="row form-check">
                <input id="service" class="form-check-input" type="radio" name="flexRadioDefault" wire:model="liaison" wire:change="handle_liaison_check()" value="service" >
                <label class="form-check-label" for="service">Service</label>
            </div>
            <div class="row form-check">
                <input class="form-check-input" type="radio" id="Produit" name="flexRadioDefault" wire:model="liaison" wire:change="handle_liaison_check()" value="produit" >
                <label class="form-check-label" for="Produit">Produit</label>
            </div>
        </div>
        
        <div class="row">
            @if($liaison == 'produit')
                {{-- Produit avec recherche --}}
                <div class="col-md-6">
                    <div class="form-floating">
                        <label for="produit">Produit</label>
                        <select id="produit"
                                name="produit_id"
                                class="form-select select2 @error('produit_id') is-invalid @enderror"
                                data-placeholder="Sélectionnez un produit"
                                required>
                            <option value="" disabled selected></option>
                            @foreach($produits as $produit)
                            <option value="{{ $produit->id }}" {{ old('produit_id') == $produit->id ? 'selected' : '' }}>
                                {{ $produit->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('produit_id')
                            <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            @elseif($liaison == 'service')
                {{-- service avec recherche --}}
                <div class="col-md-6">
                    <div class="form-floating">
                        <label for="produit">Service</label>
                        <select id="service"
                                name="service_id"
                                class="form-select select2 @error('service_id') is-invalid @enderror"
                                data-placeholder="Sélectionnez un service"
                                required>
                            <option value="" disabled selected></option>
                            @foreach($services as $service)
                            <option value="{{ $service->id }}" >
                                {{ $service->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            @endif
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option  selected disabled>Sélectionner le status</option>
                        <option value="actif">actif</option>
                        <option value="desactiver">desactiver</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Footer du formulaire --}}
    <div class="card-footer bg-light py-3 d-flex justify-content-between border-0">
        <button type="reset" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-undo me-2"></i>Réinitialiser
        </button>
        <div>
            <button type="submit" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-save me-2"></i>Enregistrer
            </button>
        </div>
    </div>
</div>