@extends('dashboard.main')

@section('content')
<div class="card">
    <div class="card-header " style="display: flex; ">
        <h3 class="">Liste des Produits</h3>
        <a href="{{route('produit.import')}}"><button type="button" class="btn btn-primary">Importer</button></a>
    </div>

    <div class="container-xl px-4 mt-n4">
        @if (session()->has('message'))
        <div class="alert alert-success alert-icon" role="alert">
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-icon-aside">
                <i class="far fa-flag"></i>
            </div>
            <div class="alert-icon-content">
                {{ session('message') }}
            </div>
        </div>
        @endif
    </div>


    <!-- /.card-header -->
    <div class="row">
        <div class="col-12">
            <div class="" style="margin-top: 2em">
                <div class="row" style="display:flex; flex-direction: row">
                    <h3 class="card-title "><strong>Liste des Produits</strong></h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;" >
                            <form method="GET" action="{{route('produit.index')}}" style="display:flex; flex-direction: row">
                                @csrf
                                
                                <input type="text" name="search" class="form-control float-right" placeholder="Search">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                            </form>
                        </div>
                    </div>
                </div>

                    <div class="card-body table-responsive table-bordered p-0" style="height: 400px; background-color: silver">
                        <table class="table table-head-fixed table-hover ">
                            <thead>
                                <tr >
                                    <th style="background-color: green;">titre</th>
                                    <th style="background-color: green;">categorie</th>
                                    <th style="background-color: green;">Stock</th>
                                    @can('IMPOT')
                                        <th style="background-color: green;">Prix d'achat</th>
                                    @endCan
                                    <th style="background-color: green;">Prix de vente</th>
                                    <th style="background-color: green;">Prix minimum</th>
                                    <th style="background-color: green;">Prix technicien</th>
                                    <th style="background-color: green;">Description</th>
                                    <th style="background-color: green;">Images</th>
                                    @can('IMPOT')
                                        <th style="background-color: green;">Actions</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produits as $produit)
                                <tr>
                                    <td style="margin-rigth: -7em">{{$produit->name}}</td>
                                    <td>{{$produit->categori->titre}}</td>
                                    <td>{{$produit->stock}}</td>
                                    @can('IMPOT')
                                        <td> {{$produit->prix_achat}}</td>
                                    @endcan
                                    <td>{{$produit->price}}</td>
                                    <td>{{$produit->prix_minimum}}</td>
                                    <td>{{$produit->prix_technicien}}</td>
                                    <td>{{$produit->description}} </td>
                                    <td><img src="{{asset('storage/images/produits/'.$produit->image_produit) ?? 'bjr'}}" class="img-fluid" alt="" style="height: 5em; width: 100%"> </td>
                                    @can('IMPOT')
                                    <td>
                                        <a href="{{ route('produit.show', $produit->id)}}">
                                            <button type="button" class="btn btn-primary">modifier</button>
                                        </a>
                                        <form action="{{route('produit.delete', $produit->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-warning" onclick="return confirm('etes vous sur de vouloir suprimer ce produit??')">suprimer</button>
                                        </form>
                                    </td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
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
@section('javascript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

</script>
@endsection