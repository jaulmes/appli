@extends('frontend.layout.index')

@section('content')
<div class="container py-5" style="margin-top: 13em;">
  <div class="row justify-content-center">
    @foreach($categories as $categorie)
      <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
        <div class="card h-100 border-0 hover-scale shadow-sm transition-all rounded-4 overflow-hidden">
          <!-- Conteneur image avec effet de zoom et animations d'entrée -->
          <div class="position-relative image-zoom-container animate__animated animate__fadeInUp">
            <img src="{{ asset('storage/images/produits/categories/' . $categorie->image_categorie) }}"
                 alt="{{ $categorie->titre }}"
                 class="img-fluid w-100 h-100 object-fit-cover zoom-image">
            <!-- Overlay interactif animé -->
            <div class="card-img-overlay d-flex flex-column justify-content-end text-center p-3 overlay-hover transition-all">
              <a href="{{ route('categorie-detail', $categorie->id) }}" wire:navigate class="btn btn-outline-light rounded-pill px-4 py-2 fw-bold animate__animated animate__zoomIn">
                Voir en détail
              </a>
            </div>
          </div>
          <!-- Corps de la carte animé -->
          <div class="card-body text-center p-3 animate__animated animate__fadeIn">
            <h5 class="fw-bold mb-0 text-truncate">{{ $categorie->titre }}</h5>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

<!-- Styles additionnels -->
<style>
  .image-zoom-container {
    height: 250px;
    overflow: hidden;
    border-radius: 8px;
    position: relative;
  }
  .zoom-image {
    transition: transform 0.5s ease-in-out;
  }
  .image-zoom-container:hover .zoom-image {
    transform: scale(1.2);
  }
  .hover-scale:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1) !important;
  }
  .card-img-overlay {
    background: rgba(0, 0, 0, 0.4);
    opacity: 0.8;
    transition: opacity 0.3s ease-in-out, background 0.3s ease-in-out;
  }
  .image-zoom-container:hover .card-img-overlay {
    background: rgba(0, 0, 0, 0.6);
    opacity: 1;
  }
  .overlay-hover a {
    position: absolute;
    bottom: 15px;
    left: 50%;
    transform: translateX(-50%);
  }
</style>

<!-- Inclusion d'Animate.css pour les animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

@endsection
