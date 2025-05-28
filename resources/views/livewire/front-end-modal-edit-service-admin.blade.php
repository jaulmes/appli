<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="editService">Enregistrer un nouveau service</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col">
                        <label for="name">Titre</label>
                        <input wire:model="name" type="text" 
                                class=" form-control" id="name" 
                                placeholder="Entrer le titre" required>
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col">
                        <label for="description">Description</label>
                        <textarea wire:model="description" placeholder="Entrer la description" 
                                class="form-control" id="description" rows="3">

                        </textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label>Status</label>
                        <select wire:model="status" class="form-control select2bs4 @error('status') is-invalid @enderror" style="width: 100%;">
                            <option selected>choisir le status du service</option>
                            <option value="actif">visible</option>
                            <option value="inactif">Caché</option>
                        </select>
                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col">
                        <div class="input-group">
                            <div class="custom-file">
                                <input wire:modal="image" type="file" wire:model="image">
                            </div>
                        </div>
                    </div>
                    @if($service->image)
                        <div class="form-group row mt-4">
                            <div class="input-group">
                                <div class="custom-file">
                                    <p>Image actuelle: </p>
                                    @php
                                        $image1 = public_path('images/services/'. $service->image);
                                        $image2 = public_path('storage/images/services/'. $service->image);
                                        $url = file_exists($image1)? asset('images/services/'. $service->image)
                                                                    : asset('storage/images/services/' . $service->image);
                                    @endphp

                                    <img src="{{$url }}"
                                        alt="Photo du service {{ $service->name }}"
                                        loading="lazy"
                                        class="img-thumbnail" style="width: 100px; height: 100px;">
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
            <button type="button" class="btn btn-primary" wire:click="editService({{$service->id}})">Enregistrer</button>
        </div>
    </div>
</div>