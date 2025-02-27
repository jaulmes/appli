<div>
    <tr>
        <td>{{ $vente->nomClient}}</td>
        <td>{{$vente->numeroClient}}</td>
        <td>{{$vente->user->name}}</td>
        <td>{{$vente->agentOperant}}</td>
        <td>{{$vente->commission}}</td>
        <td>{{$vente->qteTotal}}</td>
        <td>{{$vente->NetAPayer}}</td>
        <td>{{$vente->montantTotal}}</td>
        <td>{{$vente->montantVerse}}</td>
        <td>{{$vente->NetAPayer - $vente->montantVerse}}</td>
        <td>{{$vente->date}}</td>
        <td>{{$vente->statut}}</td>
        @if($vente->statut == "non termine")
            <td>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPaiementVente">
                    Ajouter un paiement
                </button>

                <!-- Modal -->
                <form action="{{route('ventes.ajouterPaiement', $vente->id)}}" method="post">
                    @csrf
                    <div class="modal fade" id="addPaiementVente" tabindex="-1" role="dialog" aria-labelledby="ajouterPaiementVenteTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content ">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ajouterPaiementVenteTitle"> Ajouter un paiement {{$vente->NetAPayer}}</h5>
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
                                        <label for="motif">Motif </label>
                                        <input type="text" name="remarque" id="motif" placeholder="ajouter la raison..." required class="form-control">
                                    </div>
                                    <div class="col-auto my-1 row">
                                        <label class="mr-sm-2" for="SelectCLient">Client</label>
                                        <select class="custom-select mr-sm-2" id="SelectCLient" name="client_id" >
                                            <option selected>Choisir le client</option>
                                            @foreach($clients as $client)
                                                <option value="{{$client->id}}">{{$client->nom}}</option>
                                            @endforeach
                                        </select>
                                        <label class="mr-sm-2" for="selectCompte">Compte</label>
                                        <select class="custom-select mr-sm-2" id="selectCompte" name="compte_id" >
                                            <option selected>Choisir le compte</option>
                                            @foreach($comptes as $compte)
                                                <option value="{{$compte->id}}">{{$compte->nom}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" >Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </td>
        @endif
    </tr>
</div>
