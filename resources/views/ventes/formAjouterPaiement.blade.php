@extends('dashboard.main')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <style>
        .form-container {
            max-width: 500px;
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content')
<div class="container d-flex justify-content-center mt-0">
    <div class="form-container">
        @if (session()->has('message'))
        <div class="alert alert-danger alert-icon" role="alert">
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-icon-aside">
                <i class="far fa-flag"></i>
            </div>
            <div class="alert-icon-content">
                {{ session('message') }}
            </div>
        </div>
        @endif
        <div class="text-center text-primary">Detail de la vente</div>
        <div class="card-body table-responsive p-0" style=" font-size: xx-small;" >
            <table class="table table-head-fixed  small">
                <thead>
                    <tr>
                        <th>Nom du client</th>
                        <th>Numero du client</th>
                        <th>Net A Payer</th>
                        <th>Montant Deja Versé</th>
                        <th>Reste a payer</th>
                        <th>Date enregistrement de la vente</th>
                        <th>Date limite du prochain versement</th>
                    </tr>
                </thead>
                <tbody >
                    <div>
                        <tr>
                            <td>{{$ventes->clients->nom?? $ventes->nomClient}}</td>
                            <td>{{$ventes->numeroClient}}</td>
                            <td>{{$ventes->NetAPayer}}</td>
                            <td>{{$ventes->montantVerse}}</td>
                            <td>{{$ventes->NetAPayer - $ventes->montantVerse}}</td>
                            <td>{{$ventes->date}}</td>
                            <td>{{$ventes->dateLimitePaiement}}</td>
                        </tr>
                    </div>
                </tbody>
            </table>
        </div>
        
        <h4 class="text-center text-primary">Ajouter un paiement</h4>

        <form action="{{ route('ventes.ajouterPaiement', $ventes->id) }}" method="POST">
            @csrf
            <div class="row">
                <div class="mb-3 col">
                    <label for="montant" class="form-label">Montant <span class="text-danger">*</span></label>
                    <input type="number" name="montant" id="montant" placeholder="Entrer le montant" required class="form-control">
                </div>

                <div class="mb-3 col">
                    <label for="motif" class="form-label">Motif</label>
                    <input type="text" name="remarque" id="motif" placeholder="Ajouter la raison..." required class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    @if(!$ventes->client_id)
                        <div class="mb-3">
                            <label for="SelectClient" class="form-label">Client</label>
                            <select class="form-select " id="SelectClient" name="client_id">
                                <option value="" selected disabled>Choisir le client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>

                <div class="mb-3 col">
                    <label for="selectCompte" class="form-label">Compte</label>
                    <select class="form-select " id="selectCompte" name="compte_id">
                        <option value="" selected disabled>Choisir le compte</option>
                        @foreach($comptes as $compte)
                            <option value="{{ $compte->id }}">{{ $compte->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="dateLimiteVersement" class="form-label">Date limite du prochain versement</label>
                <input type="date" name="dateLimiteVersement" id="dateLimiteVersement" class="form-control">
            </div>
            

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('javascript')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

@endsection
