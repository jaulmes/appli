@extends('dashboard.main')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-0">Bilan Mensuel</h1>
            <p class="text-muted mb-0">Analyse financière pour {{ \Carbon\Carbon::parse($moi)->translatedFormat('F Y') }}</p>
        </div>
        <a href="{{ route('transaction.index') }}" class="btn btn-outline-danger">
            <i class="fas fa-arrow-left me-2"></i> Retour aux transactions
        </a>
    </div>

    <!-- Section Résumé Financier -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <livewire:bilan-benefice-reele-mensuel :moi="$moi" />
        </div>
    </div>

    <!-- Classement produit -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-boxes-stacked me-2 text-warning"></i>Produits Populaires
                    </h5>
                </div>
                <div class="card-body">
                    <livewire:bilan-classement-client :moi="$moi" />
                </div>
            </div>
        </div>
    </div>
    <!-- Grille des indicateurs -->
    <div class="row g-4 mb-4">
        <!-- Investissement -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-sack-dollar me-2 text-info"></i>Investissements
                    </h5>
                </div>
                <div class="card-body">
                    <livewire:bilan-investissement :moi="$moi" />
                </div>
            </div>
        </div>

        <!-- Classement client -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-ranking-star me-2 text-primary"></i>Top Clients
                    </h5>
                </div>
                <div class="card-body">
                    
                    <livewire:bilan-classement-produit :moi="$moi" />
                </div>
            </div>
        </div>
    </div>

    <!-- Grille des indicateurs -->
    <div class="row g-4 mb-4">


        <!-- Classement client insolvable -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-triangle-exclamation me-2 text-danger"></i>Clients Insolvables
                    </h5>
                </div>
                <div class="card-body">
                    <livewire:bilan-classement-client-insolvable :moi="$moi" />
                </div>
            </div>
        </div>
    </div>

    <!-- etat des compte  a ajouter ici-->


    <!-- Classement charge -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-money-bill-trend-up me-2 text-success"></i>Analyse des Charges
                    </h5>
                </div>
                <div class="card-body">
                    <livewire:bilan-classement-charge :moi="$moi" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<!-- Ajoutez ici les scripts nécessaires si besoin -->
@endsection