<div class="row justify-content-center">
    @foreach($produits as $produit)
      <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
        <div class="card h-100 border-0 hover-scale overflow-hidden shadow-sm transition-all">
          <!-- Conteneur image avec effet de zoom -->
          <a href="{{ route('produit-detail', $produit->id) }}" 
                                        class="card-image-link d-block text-decoration-none position-relative">
                                        <div class="position-relative overflow-hidden image-zoom-container" 
                                            style="height: 250px;"
                                            data-tilt data-tilt-max="8">
                                            <img src="{{ $produit->getImageUrl() }}" 
                                                alt="{{ $produit->name }}" 
                                                class="img-fluid w-100 h-100 object-fit-cover zoom-image">
                                            
                                            <!-- Overlay dynamique -->
                                            <div class="card-img-overlay d-flex flex-column justify-content-between p-3">
                                                <div class="w-100 d-flex justify-content-end">
                                                    <span class="badge bg-primary rounded-pill px-3 py-2 shadow glow-label">
                                                        {{ $produit->categori->titre }}
                                                    </span>
                                                </div>

                                            </div>
                                            <div class="shine-effect"></div>
                                        </div>
                                    </a>
          <!-- Corps de la carte -->
          <div class="card-body p-3">
            <h5 class="fw-bold mb-2 text-truncate">{{ $produit->name }}</h5>
            <!-- Prix et actions -->
            <div class="d-flex align-items-center justify-content-between border-top pt-3">
              <div>
                <p class="mb-0">
                  <span class="badge bg-success" style="font-size: x-large;"><strong>{{ $produit->prix_promo }}</strong></span>
                  <small class="text-muted ms-1"><strike>{{ $produit->getPrice() }}</strike></small>
                </p>
              </div>
            </div>
            <div class="mt-3">
              <button class="btn btn-sm btn-primary rounded-pill" wire:click="addToCart({{ $produit->id }})">
                <i class="fas fa-cart-plus me-2"></i>Ajouter
              </button>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>