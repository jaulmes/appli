<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="editRealisationLabel-{{$realisation->id}}">modifier la realisation</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col">
                        <label for="titre">Titre </label>
                        <input wire:model="titre"  type="text" class="@error('title') is-invalid @enderror form-control" value="{{ $realisation->titre }}"   required>
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col">
                        <label for="description">Description</label>
                        <textarea wire:model="description" placeholder="Entrer la description" 
                            value="{{$realisation->description}}" class="@error('description') 
                            is-invalid @enderror form-control" rows="3"> {{$realisation->description}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select wire:model="status" class="form-control select2bs4 @error('status') is-invalid @enderror" style="width: 100%;">
                        <option selected value="{{$realisation->satus}}">{{$realisation->status}}</option>
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
                    <div class="form-group col">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" wire:model="img2" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group col">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" wire:model="img3" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group col">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" wire:model="img4" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group col">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" wire:model="img5" >
                            </div>
                        </div>
                    </div>
                </div>

                @if($realisation->img1)
                    @php
                        $img = 1;
                        $images = [
                            $realisation->img1, 
                            $realisation->img2, 
                            $realisation->img3, 
                            $realisation->img4, 
                            $realisation->img5
                                ];
                    @endphp
                    <div class="mt-3">
                        <label class="form-label">Images actuelles :</label><br>
                        @foreach($images as $image)
                            <p>Image: {{$img++}}</p>
                            @php
                                $image1 = public_path('images/Realisations/'. $image);
                                $url = file_exists($image1)? asset('images/realisations/'. $image)
                                                            : asset('storage/images/realisations/' . $image);
                            @endphp
                            <img src="{{$url }}"
                                class="img-fluid rounded" 
                                style="height: 100px; width: 100px; margin-right: 10px;"
                                >
                           
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" wire:click="editRealisation({{$realisation->id}})">Enregistrer</button>
        </div>
    </div>
</div>