@extends('dashboard.main')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Liste des achat effectué</h3>
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




    <!-- END: Alert -->
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Quantitée</th>
                    <th>Auteur</th>
                    <th>Montant Facture</th>
                    <th>Montant versé</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($achats as $achat)
                <tr>
                    <td>{{$achat->date}}</td>
                    <td>{{$achat->statut}}</td>
                    <td>{{$achat->qte}}</td>
                    <td> {{$achat->user->name}}</td>
                    <td> {{$achat->montantTotal}}</td>
                    <td>{{$achat->montantVerse}}</td>
                    <td></td>
                </tr>
                @endforeach
                
            </tbody>
            <tfoot>
                <tr>
                <tr>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Quantitée</th>
                    <th>Auteur</th>
                    <th>Montant Facture</th>
                    <th>Montant versé</th>
                    <th>Actions</th>
                </tr>
                </tr>
            </tfoot>
        </table>
    </div>

    
    <!-- /.card-body -->
</div>



@endsection

@section('javascript')

@endsection