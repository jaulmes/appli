<div>
    <div class="container mt-5">


        <!-- Sprint Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex gap-2">
                <span class="badge bg-secondary rounded-circle p-2">0</span>
                <span class="badge bg-primary rounded-circle p-2">0</span>
                <span class="badge bg-success rounded-circle p-2">0</span>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Ajouter une Taches
            </button>
        </div>

        <!-- Tickets Section -->
        <ul class="list-group mb-3">
        @foreach($taches as $tache)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                
                <div class="form-check">
                    <span class="fw-bold">{{$tache->titre}}</span>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <select id="" wire:model="statut" wire:change="updateStatut( {{$tache->id}} )" >
                        @if($tache->statut === "A FAIRE")
                            <option class="alert alert-dark" selected>{{$tache->statut}}</option>
                            <option class="alert alert-secondary" value="EN COURS">EN COURS</option>
                            <option class="alert alert-success" value="TERMINER">TERMINER</option>
                        @elseif($tache->statut ==="EN COURS")
                            <option class="alert alert-secondary" selected>{{$tache->statut}}</option>
                            <option class="alert alert-dark" value="A FAIRE">A FAIRE</option>
                            <option class="alert alert-success" value="TERMINER">TERMINER</option>
                        @else
                            <option class="alert alert-success" selected>{{$tache->statut}}</option>
                            <option class="alert alert-dark" value="A FAIRE">A FAIRE</option>
                            <option class="alert alert-secondary" value="EN COURS">EN COURS</option>
                        @endif
                    </select>
                    @if($tache->etat === "assigne")
                        <i class="bi bi-person-circle" title="{{$tache->assigne->name}}" type="button"></i>
                    @else
                        <div class="dropdown">
                            <span class="dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">non assigne</span>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><input type="text" class="form-control" placeholder="Rechercher..."></li>
                                @foreach($users as $user)
                                    <li><a class="dropdown-item primary" href="#" wire:click="updateAssigne({{$tache->id}}, {{$user->id}})">{{$user->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div>
                    <span type="button" class="btn btn-danger" wire:click="deleteTache({{$tache->id}})" onclick="alert('etes vous sur de vouloir suprimer cettre tache?')">
                        <i class="bi bi-trash"></i>
                    </span>
                </div>
                
            </li>
            @endforeach
        </ul>

    </div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <livewire:modal-creer-tache>
    </div>
</div>
