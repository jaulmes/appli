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

    <!-- /.card-header -->
    <div class="row">
        <div class="col-12">
            <livewire:commandes/>
        </div>
    </div>
<!-- /.card-body -->
</div>

@endsection
