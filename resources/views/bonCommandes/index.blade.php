@extends('dashboard.main')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Bon de Commandes</h1>
            <a href="{{ route('bonCommandes.create') }}" class="btn btn-primary mb-3">Créer un nouveau Bon de Commande</a>
            
        </div>
    </div>

@endsection