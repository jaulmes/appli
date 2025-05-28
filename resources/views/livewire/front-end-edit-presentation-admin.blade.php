<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="editPresentationLabel-{{$presentation->id}}">modifier la presentation</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col">
                        <label for="titre">Titre </label>
                        <input wire:model="titre"  type="text" class="@error('title') is-invalid @enderror form-control" value="{{ $presentation->title }}"   required>
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col">
                        <label for="description">Description</label>
                        <textarea wire:model="description" placeholder="Entrer la description" 
                            value="{{$presentation->description}}" class="@error('description') 
                            is-invalid @enderror form-control" rows="3"> {{$presentation->description}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select wire:model="status" class="form-control select2bs4 @error('status') is-invalid @enderror" style="width: 100%;">
                        <option selected value="{{$presentation->satus}}">{{$presentation->status}}</option>
                        <option value="actif">Actif</option>
                        <option value="inactif">Inactif</option>
                    </select>
                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Image</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" wire:model="image" class="@error('image') is-invalid @enderror">
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                @if($presentation->image)
                    <div class="mt-3">
                        <label class="form-label">Image actuelle :</label><br>
                            @php
                                $image1 = public_path('images/presentations/'. $presentation->image);
                                $image2 = public_path('storage/images/presentations/'. $presentation->image);
                                $url = file_exists($image1)? asset('images/presentations/'. $presentation->image)
                                                            : asset('storage/images/presentations/' . $presentation->image);
                            @endphp
                            <img src="{{$url }}"
                                alt="{{ $presentation->name }}"
                                class="img-fluid rounded" 
                                style="max-width: 150px;">
                    </div>
                @endif
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" wire:click="editPresentation({{$presentation->id}})">Enregistrer</button>
        </div>
    </div>
</div>