<div class="card">
    <div class="card-header">
        <h3 class="card-title">Liste des Simulations sur le site</h3>

        <div class="card-tools">
            <a target="_blank" href="{{route('simulateur')}}">
                <button type="button" class="btn btn-primary" >
                    Faire une simualation
                    <i class="bi bi-box-arrow-up-right"></i>
                </button>
            </a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr style="font-size: xx-small;">
                    <th>Simuleurs</th>
                    <th>Besoin energetique journalier</th>
                    <th>Puissance du convertisseur</th>
                    <th>Nombre de batterie</th>
                    <th>Nombre de panneaux</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($simulations as $simulation)
                <tr style="font-size: x-small;">
                    <td>
                        {{$simulation->simuleur->nom}}</br>
                        {{$simulation->simuleur->numero}}
                    </td>
                    <td>{{$simulation->besoin_energetique_journalier}}</td>
                    <td>{{$simulation->puissance_convertisseur}}</td>
                    <td>{{$simulation->nombre_batteries}}</td>
                    <td>{{$simulation->nombre_panneaux}}</td>
                    <td>{{date_format($simulation->created_at, 'd/m/Y')}}</td>
                    <td>
                        <div >
                            <a href="{{route('rapport.simulation', $simulation->id)}}" target="_blank" type="button"  title="afficher le recu"  type="button" class="btn btn-primary" >
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
    
</div>
