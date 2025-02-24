<div>
    <div class="card-header">
        <h3 class="card-title">Liste des Recus</h3>
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
    <!-- <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>
    </div> -->
</div>
