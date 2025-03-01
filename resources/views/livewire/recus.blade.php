<div class="card">
    <div class="card-header">
        <h3 class="card-title">Liste des Recus</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#creerRecu">
                Etablir un recu
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table">
            <thead>
                <tr>
                    <th>Numero</th>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Remarque</th>
                    <th>Clients</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($recus as $recu)
                <tr>
                    <td>{{$recu->numero_recu}}</td>
                    <td>{{$recu->created_at}}</td>
                    <td>{{$recu->montant_recu}}</td>
                    <td>{{$recu->remarque}}</td>
                    <td>{{$recu->clients->nom ?? ''}}</td>
                    <td>
                    <div>
                        <a href="{{route('factures.recus.afficherInstallation', $recu->id)}}" target="_blank" type="button"  title="afficher le recu"  type="button" class="btn btn-primary" >
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{route('factures.recus.afficherInstallation', $recu->id)}}" type="button" class="btn btn-danger" title="supprimer la tache"  onclick="alert('etes vous sur de vouloir suprimer cettre tache?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                    </td>
                </tr>
            @empty
                Auccun recu trouvé
            @endforelse
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="creerRecu" tabindex="-1" aria-labelledby="creerRecuLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="creerRecuLabel">Creer un recu</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="mb-3 col">
                    <label for="montant" class="form-label">Montant <span class="text-danger">*</span></label>
                    <input type="number" name="montant" wire:model="montant" id="montant" placeholder="Entrer le montant" required class="form-control">
                </div>

                <div class="mb-3 col">
                    <label for="motif" class="form-label">Motif</label>
                    <input type="text" name="remarque" wire:model="motif" id="motif" placeholder="Ajouter la raison..." required class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="SelectClient" class="form-label">Client</label>
                        <select class="form-select " id="SelectClient" wire:model="client_id">
                            <option value="" selected disabled>Choisir le client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3 col">
                    <label for="selectCompte" class="form-label">Compte</label>
                    <select class="form-select " id="selectCompte" wire:model="compte_id" >
                        <option value="" selected disabled>Choisir le compte</option>
                        @foreach($comptes as $compte)
                            <option value="{{ $compte->id }}">{{ $compte->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="dateLimiteVersement" class="form-label">Date limite du prochain versement</label>
                    <input type="date" wire:model="dateLimiteVersement" id="dateLimiteVersement" class="form-control">
                </div>
                <div class="col">
                    <label for="reste" class="form-label">Montant restant</label>
                    <input type="text" wire:model="montantRestant" id="reste" class="form-control">
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
    </div>
</div>
