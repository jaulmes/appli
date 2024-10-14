@extends('dashboard.main')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">DataTable with default features</h3>
        <a href="{{route('produit.ajouterFournisseur')}}"><button type="button" class="btn-btn primary">ajouter </button></a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>nom</th>
                    <th>prenom</th>
                    <th>telephone</th>
                    <th>localisation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fournisseurs as $fournisseurs)
                <tr>
                    <td>{{$fournisseurs->nom}}</td>
                    <td>{{$fournisseurs->prenom}}</td>
                    <td>{{$fournisseurs->telephone}}</td>
                    <td>{{$fournisseurs->localisation}}</td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

@endsection