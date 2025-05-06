<div>
    <div class="card-header border-0">
        <h3 class="card-title text-center">Presentation</h3>
        <div class="card-tools">
            <a href="javascript:void(0);">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newPresentation">
                    Nouvelle presentation
                </button>
            </a>
        </div>
        @if (session()->has('message_presentation'))
            <div class="alert alert-success">
                {{ session('message_presentation') }}
            </div>
        @endif
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-valign-middle">
            <thead>
                <tr>
                    <th>titre</th>
                    <th>Status</th>
                    <th>image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($presentations as $presentation)
                    <tr>
                        <td>
                            {{$presentation->title}}
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                @if($presentation->status == 'actif')
                                    <input class="form-check-input" wire:click="changeStatus({{$presentation->id}})" checked type="checkbox" role="switch" id="flexSwitchCheckDefault" >
                                @else
                                    <input class="form-check-input" wire:click="changeStatus({{$presentation->id}})" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="mb-3">
                                <img src="{{ asset('storage/images/presentations/'.$presentation->image)}}" alt="Product 1" class="img-fluid rounded" style="width: 40px; height: 40px;">
                            </div>
                        </td>
                        <td>
                            <i type="button" class="bi bi-pencil-square text-blue" data-bs-toggle="modal" data-bs-target="#editPresentation-{{$presentation->id}}"></i>
                            <!-- Modal -->
                            <div  class="modal fade" id="editPresentation-{{$presentation->id}}" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <livewire:front-end-edit-presentation-admin :presentation="$presentation" />
                            </div>
                            <i type="button" class="bi bi-trash text-red" wire:click="deletePresentation({{$presentation->id}})"></i>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="newPresentation" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newPresentationLabel">Enregistrer une nouvelle presentation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col">
                                <label for="titre">Titre</label>
                                <input wire:model="title" type="text" class="@error('image') is-invalid @enderror form-control" id="titre" placeholder="Entrer le titre" required>
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col">
                                <label for="description">Description</label>
                                <textarea wire:model="description" placeholder="Entrer la description" class="@error('image') is-invalid @enderror form-control" id="description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select wire:model="status" class="form-control select2bs4 @error('status') is-invalid @enderror" style="width: 100%;">
                                <option selected>choisir le status de la presentation</option>
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

                        @if ($image)
                        <div>
                            Aperçu :
                            <img src="{{ $image->temporaryUrl() }}" alt="Aperçu de l'image" style="max-width: 200px;">
                        </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="newPresentation()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('close-modal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('newPresentation'), {
                keyboard: false
            });
            myModal.hide();
        });
    </script>
</div>