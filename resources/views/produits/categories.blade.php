@extends('dashboard.main')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">DataTable with default features</h3>
        <a href="{{route('produit.ajouter_categori')}}"><button type="button" class="btn-btn primary">ajouter </button></a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>titre</th>
                    <th>description</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $categorie)
                <tr>
                    <td>{{$categorie->titre}}</td>
                    <td>{{$categorie->description}}</td>
                    <td> </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>titre</th>
                    <th>description</th>
                    <th>action</th>

                </tr>
            </tfoot>
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