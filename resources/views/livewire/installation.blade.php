<div>
    <div class="card fs-0.2" style="margin-top: 2em">
        <div class="card-header">
            <h3 class="card-title "><strong>Liste des installations</strong></h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="search"  class="form-control float-right" 
                                placeholder="Search" wire:model="query" wire:input="update_search">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body table-responsive p-0" style="height: 400px; font-size: x-small;">
            <table class="table table-head-fixed text-nowrap">
                <thead>
                    <tr>
                        <th>Nom du client</th>
                        <th>Numero du client</th>
                        <th>Autheur</th>
                        <th>Produits</th>
                        <th>Commission</th>
                        <th>Montant total des Produits</th>
                        <th>Reduction</th>
                        <th>Main d'Oeuvre</th>
                        <th>Net A Payer</th>
                        <th>Montant Deja Versé</th>
                        <th>Reste</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="result">
                    @foreach($installations as $installation)
                    <tr>
                        <td>{{$installation->nomClient}}</td>
                        <td>{{$installation->numeroClient}}</td>
                        <td>{{$installation->user->name}}</td>
                        <td>
                            @foreach($installation->produits as $produit)
                                <u>Qte</u>: {{$produit->pivot->quantity}}, <u>Titre</u>: {{$produit->name}}, <u>Prix</u>: {{$produit->pivot->price}};</br>
                            @endforeach
                        </td>
                        <td>{{$installation->commission}}</td>
                        <td>{{$installation->montantProduit}}</td>
                        <td>{{$installation->reduction}}</td>
                        <td>{{$installation->mainOeuvre}}</td>
                        <td>{{$installation->NetAPayer}}</td>
                        <td>{{$installation->montantVerse}}</td>
                        <td>{{$installation->NetAPayer - $installation->montantVerse}}</td>
                        <td>{{$installation->date}}</td>
                        <td>{{$installation->statut}}</td>
                        @if($installation->statut == "non termine")
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                                Ajouter un paiement
                                </button>

                                <!-- Modal -->
                                <form action="{{route('installations.ajouterPaiement', $installation->id)}}" method="post">
                                    @csrf
                                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content ">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle"> Ajouter un paiement</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body row ">
                                                    <div class="row">
                                                        <label for="montant">Montant <span class="invalid-feedback">*</span></label>
                                                        <input type="text" name="montant" id="montant" placeholder="Entrer le montant" required class="form-control">
                                                    </div>
                                                    <div class="row">
                                                        <label for="remarque">Motif </label>
                                                        <textarea  id="remerque" name="remarque" class="form-control" placeholder="ajouter une remarque"></textarea>
                                                    </div>
                                                    <div class="col-auto my-1 row">
                                                        @if(!$installation->client_id)
                                                            <label class="mr-sm-2" for="inlineFormCustomSelect">Client</label>
                                                            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="client_id" >
                                                                <option selected>Choisir le client</option>
                                                                @foreach($clients as $client)
                                                                    <option value="{{$client->id}}">{{$client->nom}}</option>
                                                                @endforeach
                                                            </select>
                                                        @endif
                                                        <label class="mr-sm-2" for="inlineFormCustomSelect">Compte</label>
                                                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="compte_id" >
                                                            <option selected>Choisir le compte</option>
                                                            @foreach($comptes as $compte)
                                                                <option value="{{$compte->id}}">{{$compte->nom}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" wire:click="ajouterPaiement({{$installation->id}})">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
