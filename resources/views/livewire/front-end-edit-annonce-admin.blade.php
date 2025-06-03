<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="editannonceLabel-{{$annonce->id}}">modifier la annonce</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col">
                        <label for="titre">Titre </label>
                        <input wire:model="titre"  type="text" class="@error('title') is-invalid @enderror form-control" value="{{ $annonce->titre }}"   required>
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col">
                        <label for="description">Description</label>
                        <textarea wire:model="description" placeholder="Entrer la description" 
                            value="{{$annonce->description}}" class="@error('description') 
                            is-invalid @enderror form-control" rows="3"> {{$annonce->description}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select wire:model="status" class="form-control select2bs4 @error('status') is-invalid @enderror" style="width: 100%;">
                        <option selected value="{{$annonce->satus}}">{{$annonce->status}}</option>
                        <option value="actif">Actif</option>
                        <option value="inactif">Inactif</option>
                    </select>
                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="row">
                    <div class="form-group col">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" wire:model="img1">
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="mt-3">
                    <label class="form-label">Images actuelles :</label><br>
                    @php
                        $image1 = public_path('images/annonces/'. $annonce->image);
                        $url = file_exists($image1)? asset('images/annonces/'. $annonce->image)
                                                    : asset('storage/images/annonces/' . $annonce->image);
                    @endphp
                    <img src="{{$url }}"
                        class="img-fluid rounded" 
                        style="height: 100px; width: 100px; margin-right: 10px;"
                        >
                        
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" wire:click="editannonce({{$annonce->id}})">Enregistrer</button>
        </div>
    </div>
</div>