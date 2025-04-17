<div>
    <div class="card-header border-0">
        <h3 class="card-title">REALISATIONS</h3>
        <div class="card-tools">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newRealisation">
                Nouveau 
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle">
            <thead>
                <tr>
                    <th>Presentations</th>
                    <th>Descriptions</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($realisations as $realisation)
                    <tr>
                        <td>
                            <img src="{{asset('storage/images/Realisations/'.$realisation->img1)}}" alt="{{$realisation->titre}}" class="img-circle img-size-32 mr-2">
                            {{$realisation->titre}}
                        </td>
                        <td>$13 USD</td>
                        <td>
                            <div class="form-check form-switch">
                                @if($realisation->status == 'actif')
                                    <input class="form-check-input" wire:click="changeStatus({{$realisation->id}})" checked type="checkbox" role="switch" id="flexSwitchCheckDefault" >
                                @else
                                    <input class="form-check-input" wire:click="changeStatus({{$realisation->id}})" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                @endif
                            </div>
                        </td>
                        <td>
                            <i class="fas fa-trash" type="button"></i>
                        </td>
                    </tr>
                @empty
                    <td colspan="4" style="text-align: center;"> Auccune realisation</td>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newRealisation" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newRealisationLabel">Enregistrer une nouvelle realisation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col">
                                <label for="titre">Titre</label>
                                <input wire:model="titre" type="text" class=" form-control" id="titre" placeholder="Entrer le titre" required>
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col">
                                <label for="description">Description</label>
                                <textarea wire:model="description" placeholder="Entrer la description" class="form-control" id="description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>Status</label>
                                <select wire:model="status" class="form-control select2bs4 @error('status') is-invalid @enderror" style="width: 100%;">
                                    <option selected>choisir le status de la presentation</option>
                                    <option value="actif">Actif</option>
                                    <option value="inactif">Inactif</option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col">
                                <label>Date</label>
                                <input type="date" wire:model="date" id="" class="form-control">
                            </div>
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
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                    <button type="button" class="btn btn-primary" wire:click="newRealisation()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('close-modal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('newRealisation'), {
                keyboard: false
            });
            myModal.hide();
        });
    </script>
</div>
