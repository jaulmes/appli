@extends('dashboard.main')

@section('head')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/6.1.2/ionicons.min.css">
@endsection

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row mb-4 mt-3">
        <div class="col-12 d-flex justify-content-center">
            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#gererAffichargeProduits" class="btn btn-primary btn-lg shadow px-5 py-3 fw-bold rounded-pill text-uppercase">
                <i class="bi bi-box-seam"></i> 
                Gérer les produits à afficher sur le site
            </a>
        </div>
        <!-- modal d'aficharge de la gestion de l'afficharge des produits sur le site -->
        <livewire:front-end-afficharge-produits-admin/>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <livewire:front-end-produit-promo/>
        </div>
        <div class="card">
          <livewire:front-end-service-admin/>
        </div>
        <div class="card">
          <livewire:front-end-annonce-admin/>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <livewire:front-end-presentation-view-admin/>
        </div>
        <div class="card">
          <livewire:front-end-realisation-admin/>
        </div>
        <div class="card">
          <livewire:pack-admin/>
        </div>
      </div>
      
      </div>
    </div>
  </div>
@endsection