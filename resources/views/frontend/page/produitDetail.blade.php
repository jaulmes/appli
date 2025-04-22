@extends('frontend.layout.index')

@section('content')
<div class="container py-5" style="margin-top: 10em;">
<form action=" {{route('add-to-cart', $produit->id)}}" method="post">
@csrf
  <div class="row">
    
      <div class="col-md-6">
        <div class="position-relative overflow-hidden image-zoom-container rounded shadow">
          <img src="{{ $produit->getImageUrl() }}" alt="{{ $produit->name }}" class="img-fluid w-100 h-100 object-fit-cover transition-all zoom-image">
        </div>
      </div>

      <!-- Détails du produit -->
      <div class="col-md-6">
        <h1 class="fw-bold">{{ $produit->name }}</h1>
        
        <!-- Prix et promotion -->
        <div class="mb-3">
          <span class="badge bg-success" style="font-size: x-large;"><strong>{{ $produit->getPrice() }}</strong> FCFA</span>
        </div>

        <!-- Stock -->
        <p class="text-muted">
          <strong>Disponibilité :</strong> 
          @if($produit->stock > 0)
            <span class="text-success">En stock ({{ $produit->stock }} unités)</span>
          @else
            <span class="text-danger">Rupture de stock</span>
          @endif
        </p>

        <!-- Description -->
        <p class="mb-4">{!! str_replace(';', ';<br>', e($produit->description)) !!}</p>

        <!-- Actions -->
        <div class="d-flex gap-3">
          <button class="btn btn-primary rounded-pill">
            <i class="fas fa-cart-plus me-2"></i>Ajouter au panier
          </button>
          <button class="btn btn-outline-dark rounded-pill">
            <i class="fas fa-bolt me-2"></i>Achat immédiat
          </button>
        </div>

        <!-- Catégorie -->
        <div class="mt-4">
          <span class="badge bg-secondary p-2">Catégorie : {{ $produit->categori->titre }}</span>
        </div>
      </div>
    <!-- Image du produit -->
    
  </div>
  
  </form>
</div>

<!-- Styles additionnels -->
<style>
  .image-zoom-container {
    transition: transform 0.3s;
    overflow: hidden;
    max-height: 400px;
  }
  .zoom-image {
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .image-zoom-container:hover .zoom-image {
    transform: scale(1.2);
  }
</style>
@endsection
