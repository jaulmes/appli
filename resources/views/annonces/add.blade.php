@extends('dashboard.main')

@section('content')

{{-- --- Header amélioré --- --}}
<header class="page-header bg-gradient-primary-to-secondary pb-1 mb-1">
    <div class="container-xl px-4">
        <div class="d-flex align-items-center">
            <div class="page-header-icon bg-white bg-opacity-25 rounded-circle p-3 me-3">
                <i class="fas fa-receipt fa-lg "></i>
            </div>
            <h1 class="h3  mb-0">Nouvelle Annonce</h1>
        </div>
    </div>
</header>

{{-- --- Contenu principal amélioré --- --}}
<div class="container-xl px-4">
    <livewire:front-end-add-annonce-admin />
</div>

{{-- Styles personnalisés --}}
@push('styles')
<style>
.page-header {
  box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}
.card {
  transition: transform .3s, box-shadow .3s;
}
.card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.1);
}
.select2-container--bootstrap-5 .select2-selection--single {
  height: calc(1.5em + .75rem + 2px) !important;
  padding: .375rem .75rem !important;
}
</style>
@endpush

{{-- Scripts avancés --}}
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Init Select2
    $('.select2').select2({
      theme: 'bootstrap-5',
      placeholder: 'Sélectionnez...',
      allowClear: true,
      dropdownParent: $('.card-body')
    });

    // Bootstrap validation
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function(form) {
      form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  });
</script>
@endpush

@endsection