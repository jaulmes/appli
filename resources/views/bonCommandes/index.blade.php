@extends('dashboard.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Carte principale pour contenir le contenu -->
            <div class="card my-4">
                <!-- En-tête de la carte avec titre et bouton d'action -->
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="d-flex justify-content-between align-items-center px-3">
                            <h6 class="text-white text-capitalize ps-3"><i class="fas fa-file-invoice-dollar me-2"></i>Bons de Commande</h6>
                            <a href="{{ route('bonCommandes.create') }}" class="btn btn-light mb-0">
                                <i class="fas fa-plus me-2"></i>Créer un Bon
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Corps de la carte avec la table -->
                <div class="card-body px-0 pb-2">
                    <livewire:liste-bon-commande/>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- N'oubliez pas d'inclure Font Awesome si ce n'est pas déjà fait dans votre layout principal -->
<!-- Par exemple, dans votre <head> : -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> -->

@endsection
