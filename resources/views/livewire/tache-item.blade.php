<div>
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <li class="list-group-item d-flex justify-content-between align-items-center" >  
        <div class="form-check">
            <span class="fw-bold">{{$tache->titre}}</span>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <select id="" wire:model="statut" wire:model="tacheId" wire:change="updateStatut( {{$tache->id}} )" >
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
            <span type="button" title="voir les details de la tache"  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#voirDetail-{{ $tache->id }}">
                <i class="bi bi-eye"></i>
            </span>
            <span type="button" class="btn btn-danger" title="supprimer la tache" wire:click="deleteTache({{$tache->id}})" onclick="alert('etes vous sur de vouloir suprimer cettre tache?')">
                <i class="bi bi-trash"></i>
            </span>
        </div>
    </li>
    <!-- Modal pour afficher les detail de chaque tache -->
    <div class="modal fade" id="voirDetail-{{ $tache->id }}" tabindex="-1" aria-labelledby="detail" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <livewire:modal-voir-tache :tache="$tache">
        </div>
    </div>
</div>
