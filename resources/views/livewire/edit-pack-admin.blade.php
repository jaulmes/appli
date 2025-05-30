<div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editPackLabel">Modifier le Pack</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        @php
                            $image1 = public_path('images/packs/'. $pack->image);
                            $url = file_exists($image1) ? asset('images/packs/'. $pack->image)
                                                       : asset('storage/images/packs/' . $pack->image);
                        @endphp
                        <img src="{{ $url }}"
                             alt="Image actuelle"
                             class="d-block w-75 object-fit-cover"
                             style="height: 100px; border-radius: 10px;">

                                                <div class="mb-3">
                            <label for="image" class="form-label">Nouvelle image </label>
                            <input type="file" class="form-control" wire:model="newImage">
                            @error('newImage') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        @if($newImage)
                            <div class="row-md-6">
                                <img src="{{ $newImage->temporaryUrl() }}" style="width: 150px; height: 150px" alt="Image Preview" class="img-fluid rounded">
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre du Pack</label>
                            <input type="text" class="form-control" wire:model="titre" value="{{$pack->titre}}" id="titre" >
                            @error('titre') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="prix" class="form-label">Prix</label>
                            <input type="number" class="form-control" value="{{$pack->prix}}" id="prix" wire:model="prix">
                            @error('prix') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" rows="4"  wire:model="description">{{ $pack->description}}</textarea>
                            @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>


                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" wire:click="editPack({{ $pack->id}})" class="btn btn-primary">
                    <i class="bi bi-save"></i> Enregistrer les modifications
                </button>
            </div>
        </div>
</div>
