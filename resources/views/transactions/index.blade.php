@extends('dashboard.main')

@section('content')
<div class="container-fluid my-4">
    <!-- Message d'alerte -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Journal des Activités -->
    <livewire:transaction-mensuel/>
</div>
@endsection

@section('javascript')
<script>
    // Permet de synchroniser le mois sélectionné du formulaire de transactions avec le bilan
    document.getElementById('transactionMonth').addEventListener('change', function() {
        document.getElementById('bilanMonth').value = this.value;
    });
</script>
@endsection
