<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="editBon">Details de la bon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body fs-0.1">
        <div class="row">
            <div class="mb-3 col">
                <label for="exampleFormControlInput1" class="form-label">Titre</label>
                <div>
                    <span>{{$bon->titre}}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col">
                <label for="validationCustom04" class="form-label">Statut</label>
                <div>
                    <select wire:model="status" id="">
                        <option value="{{$bon->status}}">{{$bon->status}}</option>
                        <option value="livré">livré</option>
                        <option value="en cours">en cours</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col">
                <label for="validationCustom04" class="form-label">Responsable</label>
                <div>
                    <span>{{$bon->users->name}}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col">
                <label for="validationCustom04" class="form-label">date de commande</label>
                <div>
                    <span>{{$bon->date_commande}}</span>
                </div>
            </div>
            <div class="col-md-6 col">
                <label for="validationCustom04" class="form-label">date de livraison</label>
                <div>
                    <input type="date" value="{{$bon->date_livraison}}" class="form-control" wire:model="date_livraison" placeholder="date de livraison">
                </div>
            </div>
        </div>
        <div>
            <h4 class="text-center">produit</h4>
            <ul>
                @foreach($bon->produits as $produit)
                    <li> {{$produit->name}}: {{$produit->pivot->quantity}} </li>
                @endforeach 
            </ul>
            <button class="btn btn-primary" wire:click="editBon({{$bon->id}})">Modifier</button>
        </div>

    </div>
</div>
