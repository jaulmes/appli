<div>
  <div class="card-header border-0 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
      <h1 class="card-title m-0">Gestion des services</h1>
      
      <button style="margin-left: 8em;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newService">
          <i class="fas fa-plus me-1"></i> Nouveau
      </button>
  </div>

  <!-- Alerts -->
  <div class="mt-3">
      @if (session()->has('successServices'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('successServices') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
          </div>
      @endif

      @if (session()->has('errorServices'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('errorServices') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
          </div>
      @endif

      @if (session()->has('deleteServices'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('deleteServices') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
          </div>
      @endif
      @if (session()->has('updateStatusServices'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('updateStatusServices') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
          </div>
      @endif
  </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Descriptions</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr>
                        <td>
                            <img src="{{asset('storage/images/services/'.$service->image)}}" alt="{{$service->name}}" class="img-circle img-size-32 mr-2">
                            {{$service->name}}
                        </td>
                        <td>{{$service->description}}</td>
                        <td>
                            <div class="form-check form-switch">
                                @if($service->status == 'actif')
                                    <input class="form-check-input" wire:click="updateStatus({{$service->id}})" checked type="checkbox" role="switch" id="flexSwitchCheckDefault" >
                                @else
                                    <input class="form-check-input" wire:click="updateStatus({{$service->id}})" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                @endif
                            </div>
                        </td>
                        <td>
                            <!-- Modal modifier service-->
                            <div  class="modal fade" id="editService-{{$service->id}}" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <livewire:front-end-modal-edit-service-admin :service="$service" />
                            </div>
                            <i class="fas fa-edit text-blue" type="button"  data-bs-toggle="modal" data-bs-target="#editService-{{$service->id}}"></i>
                            <i class="fas fa-trash text-red" type="button" wire:click="deleteService({{$service->id}})"></i>
                        </td>
                    </tr>
                @empty
                    <td colspan="4" style="text-align: center;"> Auccun service</td>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newService" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newService">Enregistrer un nouveau service</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col">
                                <label for="name">Titre</label>
                                <input wire:model="name" type="text" class=" form-control" id="name" placeholder="Entrer le titre" required>
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
                                        <input type="file" wire:model="image">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fermer</button>
                    <button type="button" class="btn btn-primary" wire:click="createService()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('close-modal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('newService'), {
                keyboard: false
            });
            myModal.hide();
        });
    </script>
</div>
