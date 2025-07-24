@extends('dashboard.main')

@section('content')
<div class="mb-3">
    <a href="{{ route('transaction.index') }}" class="btn btn-danger">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="card " style="text-align: center; align-items: center;">
    <div class="card-header badge bg-black">
        <h4 class="card-title">Bilan Mensuel</h4>
    </div>

    <div class="card-body">
        <!-- Classement charge -->
        <div class="">
            <div class="card h-100">
                <div class="card-body">
                    <livewire:bilan-benefice-reele-mensuel :moi="$moi" />
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Classement client -->
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <livewire:bilan-classement-client :moi="$moi" />
                    </div>
                </div>
            </div>

            <!-- Classement produit -->
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <livewire:bilan-classement-produit :moi="$moi" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Classement client insolvable -->
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <livewire:bilan-classement-client-insolvable :moi="$moi" />
                    </div>
                </div>
            </div>
            <!-- Classement charge -->
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <livewire:bilan-classement-charge :moi="$moi" />
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection

@section('javascript')
<!-- Ajoutez ici les scripts nécessaires si besoin -->
@endsection
