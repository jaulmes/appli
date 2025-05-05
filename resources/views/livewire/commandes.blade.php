<div class="card" style="margin-top: 2em">
    @if(session()->has('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <div class="card-header">
        <h3 class="card-title "><strong>Liste des commandes</strong></h3>
        <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" id="search" name="search" class="form-control float-right" placeholder="Search">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body table-responsive p-0" style="height: 400px; font-size:small">
        <table class="table table-head-fixed text-nowrap small">
            <thead>
                <tr>
                    <th>Nom du client</th>
                    <th>Numero du client</th>
                    <th>Produits</th>
                    <th>Montant total</th>
                    <th>status</th>
                    <th>Date</th>
                    <th>validité</th>
                </tr>
            </thead>
            <tbody id="result" style="font-size: xx-small;">
                @foreach($commandes as $commande)
                <div>
                    <tr>
                        <td>{{$commande->clients->nom}}</td>
                        <td>{{$commande->clients->numero}}</td>
                        <td>
                            @foreach($commande->produits as $produit)
                                <strong>Nom:</strong> {{$produit->name}} <strong>Qte: </strong> {{$produit->pivot->quantity}} <span class="{{$produit->pivot->status_produit == 'en stock'? 'badge badge-success' : 'badge badge-danger'}}">{{$produit->pivot->status_produit}}</span><br>
                            @endforeach
                        </td>
                        <td>
                            <strong>{{$commande->montant_total}}</strong> <br>
                        </td>
                        <td>
                            @if($commande->status == 0)
                                <span class="btn btn-primary" wire:click="marquerCommeLue({{$commande->id}})">marquer lue &#10003;&#10003; </span>
                            @else
                                <span class="badge badge-btn bg-success" >Lue <span style="color: blue;" class="badge badge-btn bg-success">&#10003;&#10003;</span> </span>
                            @endif
                        </td>
                        <td>
                            {{$commande->created_at->format('d/m/Y')}}
                        </td>
                        @if($commande->validation == 0)
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Valider la commande
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <livewire:modal-valider-commande :commandeId="$commande->id"/>
                                    </div>
                                </div>
                            </td>
                        @endif
                    </tr>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>