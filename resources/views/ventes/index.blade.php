@extends('dashboard.main')

@section('content')

<div class="card">
    <div class="card-header">
        <!-- Boutons de filtre -->
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-secondary active filtre" data-statut="tout">Tout</button>
            <button type="button" class="btn btn-secondary filtre" data-statut="non_termine">non termine</button>
            <button type="button" class="btn btn-secondary filtre" data-statut="termine">termine</button>
        </div>
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
    <div class="row">
        <div class="col-12">
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

                <div class="card-body table-responsive p-0" style="height: 400px;">
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
                                <th>Date</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="result" style="font-size: small;">
                            @foreach($ventes as $vente)
                            <tr>
                                <td>{{$vente->nomClient}}</td>
                                <td>{{$vente->numeroClient}}</td>
                                <td>{{$vente->user->name}}</td>
                                <td>{{$vente->agentOperant}}</td>
                                <td>{{$vente->commission}}</td>
                                <td>{{$vente->qteTotal}}</td>
                                <td>{{$vente->NetAPayer}}</td>
                                <td>{{$vente->montantTotal}}</td>
                                <td>{{$vente->montantVerse}}</td>
                                <td>{{$vente->date}}</td>
                                <td>{{$vente->statut}}</td>
                                <td></td>
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



@endsection

@section('javascript')
    @include('ventes.vente_js')
@endsection