@extends('frontend.layout.index')

<!-- Meta Open Graph & product pour Facebook -->
@section('head')
    <!-- Balises Open Graph obligatoires -->
    <meta property="og:type" content="product" />
    <meta property="og:title" content="{{ $produit->name }}" />
    <meta property="og:description" content="{{ Str::limit($produit->description, 100) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ $produit->getImageUrl() }}" />

    <!-- Balises produit spécifiques (Meta Commerce) -->
    <meta property="product:brand" content="{{ $produit->fabricant }}" /> <!-- À remplacer par votre marque -->
    <meta property="product:availability" content="{{ $produit->stock > 0 ? 'in stock' : 'out of stock' }}" />
    <meta property="product:condition" content="new" />
    <meta property="product:price:amount" content="{{ $produit->status_promo ? $produit->prix_promo : $produit->price }}" />
    <meta property="product:price:currency" content="XAF" />
    <meta property="product:retailer_item_id" content="{{ $produit->id }}" />
    <meta property="product:item_group_id" content="{{ $produit->categori->id }}" />
    
    <!-- Optionnel : Catégorie structurée -->
    <meta property="product:category" content="{{ $produit->categori->titre }}" />
    
  <script>
    fbq('track', 'ViewContent', {
      content_ids: ['{{ $produit->id }}'],
      content_type: 'product',
    });
  </script>                     
@endsection

@section('content')
<div class="container py-5" style="margin-top: 10em;">
  <form action="{{ route('add-to-cart', $produit->id) }}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
          <div class="position-relative overflow-hidden image-zoom-container rounded shadow">
            <img src="{{ $produit->getImageUrl() }}" 
                 alt="{{ $produit->name }}" 
                 class="img-fluid w-100 h-100 object-fit-cover transition-all zoom-image">
          </div>
        </div>

        <div class="col-md-6">
          <h1 class="fw-bold">{{ $produit->name }}</h1>
          
          <!-- Prix dynamique avec promotion -->
          <div class="mb-3">
            @if($produit->status_promo)
              <del class="text-muted me-2">{{ number_format($produit->price, 0, ',', ' ') }} FCFA</del>
              <span class="badge bg-success" style="font-size: x-large;">
                {{ number_format($produit->prix_promo, 0, ',', ' ') }} FCFA
              </span>
            @else
              <span class="badge bg-success" style="font-size: x-large;">
                {{ number_format($produit->price, 0, ',', ' ') }} FCFA
              </span>
            @endif
          </div>



          <!-- Description formatée -->
          <div class="mb-4 product-description">
            {!! str_replace(';', '<br>', e($produit->description)) !!}
          </div>

          <!-- Actions d'achat -->
          <div class="d-flex gap-3 mb-4">
            @if($produit->stock > 0)
              <button type="submit" class="btn btn-primary rounded-pill px-4 py-2">
                <i class="fas fa-cart-plus me-2"></i>Ajouter au panier
              </button>
            @else
              <button type="submit" class="btn btn-outline-dark rounded-pill px-4 py-2">
                <i class="fas fa-bolt me-2"></i>Reserver maintenant
              </button>
            @endif
          </div>

          <!-- Métadonnées structurées -->
          <div class="mt-4 text-muted small">
            <div>
              <i class="fas fa-layer-group me-2"></i>Catégorie : {{ $produit->categori->titre }}
            </div>
          </div>
        </div>
    </div>
  </form>
</div>

<style>
  .image-zoom-container {
    transition: transform 0.3s;
    overflow: hidden;
    max-height: 500px; /* Taille augmentée pour mobile */
  }

  .zoom-image {
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    min-height: 300px;
    object-position: center;
  }

  .product-description {
    line-height: 1.6;
    white-space: pre-line;
  }

  @media (max-width: 768px) {
    .container {
      margin-top: 5em !important;
    }
    
    .image-zoom-container {
      max-height: 300px;
    }
  }
</style>
@endsection