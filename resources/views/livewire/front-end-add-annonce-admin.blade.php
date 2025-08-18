<div class="card shadow-lg border-0 rounded-lg mb-5" >

    {{-- Card header --}}
    <div class="card-header bg-white border-0 py-3">
        <h5 class="mb-0 text-primary">
            <i class="fas fa-file-invoice-dollar me-2"></i>Détails de l'annonce
        </h5>
    </div>

    <div class="card-body p-4" >
        
        <div class="row consumption" >
            <div class="col">
                <label for="">Liaison de l'annonce {{$liaison}} </label>
                <div class="row form-check">
                    <input class="form-check-input" type="radio" id="service" name="liaison" wire:change="handleLiaisonChange()" wire:model="liaison"  value="service" >
                    <label class="form-check-label" for="service">Service</label>
                </div>
                <div class="row form-check">
                    <input class="form-check-input" type="radio" id="Produit" name="liaison" wire:change="handleLiaisonChange()" wire:model="liaison"  value="produit">
                    <label class="form-check-label" for="Produit">Produit</label>
                </div>
            </div>
            
            <div class="col">
                
            <!-- Section pour le produit -->
                @if($liaison === 'produit')
                    <div class="col-md-6" >
                        <div class="form-group">

                            <label >Produit</label>
                            <select 
                                id="produit_id"
                                wire:model="produit_id"
                                class="form-control select2  "
                                >
                                <option  selected>choisir le produit</option>
                                @foreach($produits as $produit)
                                    <option value="{{ $produit->id }}">
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
                @endif  
                @if($liaison === 'service')
                    <!-- Section pour le service -->
                    <div class="col-md-6"  >
                        <div class="form-floating">
                            <label for="service">Service</label>
                            <select     
                                    wire:model="service_id"
                                    
                                
                                    id="service"
                                    name="service_id"
                                    class="form-select select2 @error('service_id') is-invalid @enderror"
                                    data-placeholder="Sélectionnez un service"
                                    required>
                                <option  selected>choisir le service</option>
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
        </div>
        <div class="row g-4 mt-3 consumption">
            <div class="form-floating col py-5">
                <input type="file"
                    class="form-control @error('image') is-invalid @enderror"
                    id="image"
                    wire:model.defer="image"
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
        
        <div class="row mt-3 consumption">
            <div class="col-md-6">
                <select name="status" wire:model="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option  selected >Sélectionner le status</option>
                    <option value="actif">actif</option>
                    <option value="desactiver">desactiver</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Footer du formulaire --}}
    <div class="card-footer bg-light py-3 d-flex justify-content-between border-0">
        <div>
            <button type="submit" wire:click="addAnnonce()" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-save me-2"></i>Enregistrer
            </button>
        </div>
    </div>
    <style>
        .consumption {
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            padding: 1rem;
        }
        .consumption:hover {
            transform: translateY(-5px);
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
</div>