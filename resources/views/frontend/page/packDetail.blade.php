@extends('frontend.layout.index')

@section('content')
<div class="container py-5" style="margin-top: 10em;">
  <form action="{{ route('add-pack-to-cart', $pack->id) }}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
          <div class="position-relative overflow-hidden image-zoom-container rounded shadow">
            @php
                $image1 = public_path('images/packs/'. $pack->image);
                $url = file_exists($image1)? asset('images/packs/'. $pack->image)
                                            : asset('storage/images/packs/' . $pack->image);
            @endphp
            <img src="{{$url }}"
                alt="Photo de {{ $pack->titre }}"
                class="img-fluid w-100 h-100 object-fit-cover zoom-image"
                style="height: 50px; padding-top: -3em;"
                >
            <img src="{{ asset('storage/images/packs/'.$pack->image) }}"
                 alt="{{ $pack->name }}" 
                 class="img-fluid w-100 h-100 object-fit-cover transition-all zoom-image">
          </div>
        </div>

        <div class="col-md-6">
          <h1 class="fw-bold">{{ $pack->titre }}</h1>
          
          <!-- Prix dynamique avec promotion -->
          <div class="mb-3">
            @if($pack->status_promo)
              <del class="text-muted me-2">{{ number_format($pack->price, 0, ',', ' ') }} FCFA</del>
              <span class="badge bg-success" style="font-size: x-large;">
                {{ number_format($pack->prix_promo, 0, ',', ' ') }} FCFA
              </span>
            @else
              <span class="badge bg-success" style="font-size: x-large;">
                {{ number_format($pack->prix, 0, ',', ' ') }} FCFA
              </span>
            @endif
          </div>



          <!-- Description formatée -->
          <div class="mb-4 product-description">
            {!! str_replace(';', '<br>', e($pack->description)) !!}
          </div>

          <!-- Actions d'achat -->
          <div class="d-flex gap-3 mb-4">
            @if($pack->stock > 0)
              <button type="submit" class="btn btn-primary rounded-pill px-4 py-2">
                <i class="fas fa-cart-plus me-2"></i>Ajouter au panier
              </button>
            @else
              <button type="submit" class="btn btn-outline-dark rounded-pill px-4 py-2">
                <i class="fas fa-bolt me-2"></i>Reserver maintenant
              </button>
            @endif
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