<div>
    <div class="card fs-0.2" style="margin-top: 2em">
        <div class="card-header">
            <h3 class="card-title "><strong>Liste des Ventes</strong></h3>
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

        <div class="card-body table-responsive p-0" style="height: 400px;">
            <table class="table table-head-fixed text-nowrap">
                <thead>
                    <tr>
                        <th>Nom du client</th>
                        <th>Numero du client</th>
                        <th>Autheur</th>
                        <th>Quantitée</th>
                        <th>Net A Payer</th>
                        <th>Commission</th>
                        <th>Reduction</th>
                        <th>Montant total</th>
                        <th>Montant Deja Versé</th>
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
                        <td>{{$installation->qteTotal}}</td>
                        <td>{{$installation->NetAPayer}}</td>
                        <td>{{$installation->commission}}</td>
                        <td>{{$installation->reduction}}</td>
                        <td>{{$installation->montantTotal}}</td>
                        <td>{{$installation->montantVerse}}</td>
                        <td>{{$installation->date}}</td>
                        <td>{{$installation->statut}}</td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
