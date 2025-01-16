
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="creerTache">Creer une tache</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body fs-0.1">
            <div class="row">
                <div class="mb-3 col">
                    <label for="exampleFormControlInput1" class="form-label">Titre de la tache</label>
                    <input type="email" class="form-control" wire:model="titre" id="exampleFormControlInput1" >
                </div>
                <div class="mb-3 col ">
                    <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                    <textarea class="form-control" wire:model="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col">
                    <label for="validationCustom04" class="form-label">Statut</label>
                    <select class="form-select" wire:change="statut()" wire:model="statut" id="validationCustom04" required>
                        <option selected >Choisir le statut</option>
                        <option value="A FAIRE" >A FAIRE</option>
                        <option value="EN COURS">EN COURS</option>
                        <option value="TERMINE" >TERMINE</option>
                    </select>
                </div>
                <div class="mb-3 col">
                    <label for="exampleFormControlInput1" class="form-label">Date de debut</label>
                    <input type="date" class="form-control" wire:model="date_debut" id="exampleFormControlInput1" >
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col">
                    <label for="exampleFormControlInput1" class="form-label">Datte de fin</label>
                    <input type="date" class="form-control" wire:model="date_fin" id="exampleFormControlInput1" >
                </div>
                <div class="col-md-6 col">
                    <label for="validationCustom04" class="form-label">personne assigné</label>
                    <select class="form-select" wire:change="assigned_user()" wire:model="user" id="validationCustom04" required>
                        <option selected  >choisir un utilisateur</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}} - {{$user->email}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit" wire:click="save()">Save changes</button>
        </div>
    </div>
