@extends('dashboard.main')

@section('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<style>
    .form-container {
        max-width: 600px;
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    }
    .select2-container--default .select2-selection--single {
        height: 38px;
        padding-top: 4px;
    }
    .btn-add-client {
        margin-top: 32px;
    }
    .modal-header {
        background-color: #4e73df;
        color: white;
    }
</style>
@endsection

@section('content')

<div class="container d-flex justify-content-center mt-0">
    <div class="form-container">
        @if (session()->has('message'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            {{ session('message') }}
        </div>
        @endif

        <h4 class="text-center text-primary mb-4"><i class="fas fa-file-invoice-dollar mr-2"></i>Créer un nouveau reçu</h4>

        <form action="{{ route('recus.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="montant" class="form-label">Montant <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                        <input type="number" name="montant" id="montant" placeholder="Entrer le montant" required class="form-control">
                    </div>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="motif" class="form-label">Motif <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-comment"></i></span>
                        <input type="text" name="remarque" id="motif" placeholder="Ajouter la raison..." required class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="SelectClient" class="form-label">Client <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select class="form-control select2" id="SelectClient" name="client_id" >
                                <option value="" selected disabled>Choisir le client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->nom }}</option>
                                @endforeach
                            </select>
                            <button type="button" id="nouveau_client" class="btn btn-success input-group-text btn-add-client">
                                <i class="fas fa-plus">nouveau client</i>
                            </button>
                            <div id="cordonne_nouveau_client" class="row" style="display: none;">
                                <div class="col">
                                    <input type="text" class="form-control mt-2" id="nom_client" name="nom_client" placeholder="Nom du client">
                                    <input type="number" class="form-control mt-2" id="numero_client" name="numero_client" placeholder="numero du client">
                                </div>
                                <div class="col">
                                    <input type="email" class="form-control mt-2" id="email_client" name="email_client" placeholder="email du client">
                                    <input type="text" class="form-control mt-2" id="adresse_client" name="adresse_client" placeholder="addresse du client">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="selectCompte" class="form-label">Compte <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="selectCompte" name="compte_id" required>
                            <option value="" selected disabled>Choisir le compte</option>
                            @foreach($comptes as $compte)
                                <option value="{{ $compte->id }}">{{ $compte->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="dateLimiteVersement" class="form-label">Date limite du prochain versement</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        <input type="date" name="dateLimiteVersement" id="dateLimiteVersement" class="form-control">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="reste" class="form-label">Reste</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-coins"></i></span>
                        <input type="number" name="reste" id="reste" class="form-control">
                    </div>
                </div>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save mr-2"></i> Enregistrer
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

<script>
$(document).ready(function() {
    // Initialisation de Select2
    $('.select2').select2({
        width: '100%',
        placeholder: "Sélectionnez une option",
        allowClear: true
    });

});
</script>
<script>
    let nouveauClientButton = document.getElementById('nouveau_client');
    let cordonneNouveauClient = document.getElementById('cordonne_nouveau_client');
    nouveauClientButton.addEventListener('click', function() {
        if (cordonneNouveauClient.style.display === 'none' || cordonneNouveauClient.style.display === '') {
            cordonneNouveauClient.style.display = 'block';
            nouveauClientButton.innerHTML = '<i class="fas fa-minus"></i>';
        } else {
            cordonneNouveauClient.style.display = 'none';
            nouveauClientButton.innerHTML = '<i class="fas fa-plus"> nouveau client</i>';
        }
    });
</script>
@endsection