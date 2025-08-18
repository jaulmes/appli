@extends('dashboard.main')

@section('head')
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
<!-- BS Stepper -->
<link rel="stylesheet" href="{{ asset('plugins/bs-stepper/css/bs-stepper.min.css') }}">
<!-- dropzonejs -->
<link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center mb-3">
            <div class="col-md-10">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Erreur :</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('erreur'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('erreur') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card card-primary shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Modifier un compte</h3>
                        <small class="text-muted">ID : {{ $comptes->id }}</small>
                    </div>

                    <form method="POST" action="{{ route('dashboard.compte.update', $comptes->id) }}" id="compteForm" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="row g-3">
                                {{-- Nom --}}
                                <div class="col-12 col-md-6">
                                    <label for="nom" class="form-label">Nom</label>
                                    <input
                                        name="nom"
                                        id="nom"
                                        type="text"
                                        class="form-control @error('nom') is-invalid @enderror"
                                        placeholder="Entrer le nom du compte"
                                        value="{{ old('nom', $comptes->nom) }}"
                                        required
                                        autofocus
                                    >
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Numéro --}}
                                <div class="col-12 col-md-6">
                                    <label for="numero" class="form-label">Numéro</label>
                                    <input
                                        name="numero"
                                        id="numero"
                                        type="text"
                                        inputmode="numeric"
                                        class="form-control @error('numero') is-invalid @enderror"
                                        placeholder="Ex : 670000000"
                                        value="{{ old('numero', $comptes->numero) }}"
                                    >
                                    @error('numero')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Montant --}}
                                <div class="col-12 col-md-6">
                                    <label for="montant" class="form-label">Montant (FCFA)</label>
                                    <input
                                        name="montant"
                                        id="montant"
                                        type="number"
                                        step="0.01"
                                        class="form-control @error('montant') is-invalid @enderror"
                                        placeholder="Montant en FCFA"
                                        value="{{ old('montant', $comptes->montant) }}"
                                    >
                                    @error('montant')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('dashboard.compte') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-chevron-left me-1"></i> Annuler
                                </a>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fas fa-save me-1"></i> Enregistrer
                                </button>
                            </div>
                        </div>
                    </form>

                </div> {{-- end card --}}
            </div>
        </div>
    </div>
</section>
@endsection

@section('javascript')
<!-- Scripts groupés via asset() -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script src="{{ asset('plugins/dropzone/min/dropzone.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialisation tooltips et composants
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (el) {
            new bootstrap.Tooltip(el);
        });

        // Select2 si besoin
        if (typeof $.fn.select2 !== 'undefined') {
            $('.select2').select2({ theme: 'bootstrap4' });
        }

        // Input mask si nécessaire
        if ($.isFunction($.fn.inputmask)) {
            $(":input").inputmask();
        }

        // Désactiver le bouton submit après clic pour éviter double envoi
        var form = document.getElementById('compteForm');
        var submitBtn = document.getElementById('submitBtn');
        form.addEventListener('submit', function (e) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Enregistrement...';
        });
    });
</script>
@endsection
