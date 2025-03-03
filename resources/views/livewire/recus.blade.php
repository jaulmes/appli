<div class="card">
    <div class="card-header">
        <h3 class="card-title">Liste des Recus</h3>

        <div class="card-tools">
            <a href="{{route('recus.create')}}">
                <button type="button" class="btn btn-primary" >
                    Etablir un recu
                </button>
            </a>
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
                        <a href="{{route('factures.recus.afficher', $recu->id)}}" target="_blank" type="button"  title="afficher le recu"  type="button" class="btn btn-primary" >
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="#" type="button" class="btn btn-danger" title="supprimer la tache"  onclick="confirm('etes vous sur de vouloir suprimer cettre tache?')">
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
    
</div>
