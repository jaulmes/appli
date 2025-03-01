<div class="card" style="margin-top: 2em">
    <div class="card-header">
        <h3 class="card-title "><strong>Liste des Ventes</strong></h3>
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
                    <th>Autheur</th>
                    <th>Agent Operant</th>
                    <th>Commission</th>
                    <th>Quantitée</th>
                    <th>Net A Payer</th>
                    <th>Montant total</th>
                    <th>Montant Deja Versé</th>
                    <th>Reste a payer</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="result" style="font-size: xx-small;">
                @foreach($ventes as $vente)
                    <livewire:vente-item :vente="$vente" :key="$vente->id">
                @endforeach
            </tbody>
        </table>
    </div>
</div>