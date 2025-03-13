@extends('dashboard.main')

@section('head')
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Ionicons CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/6.1.2/ionicons.min.css">
@endsection
@section('content')

<div>
    <button class="btn btn-danger">Retour</button>
</div>

<div class="card">
    <div class="card-header border-0 ">
        <h3 class="message">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </h3>
    <h3 class="card-title ">Tous les produits en promotion</h3>
        <div class="card-tools">
            <div>
                <!-- Button trigger modal -->
                <button type="button" class="badge bg-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                ajouter un produit
                </button>

                <!-- Modal -->
                <livewire:front-end-modal-all-product>
            </div>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Prix </th>
                    <th>Prix promo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produit_promo as $produit)
                    <tr>
                        <td>
                            <img src="{{ $produit->getImageUrl() }} " alt="Product 1" class="img-circle img-size-32 mr-2">
                            {{$produit->name}}
                        </td>
                        <td>{{$produit->price}}</td>
                        <td>
                            {{$produit->prix_promo}}
                        </td>
                        <td>
                            <a href="#" class="text-muted badge bg-danger">
                                annuler la promo
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>
                            <p> auccun produit en promotion ...<i class="bi bi-exclamation-circle "></i></p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
            <!-- /.card --> 
@endsection