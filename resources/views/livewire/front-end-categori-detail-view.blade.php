<div class="row justify-content-center">
    @foreach($produits as $produit)
      <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
        <div class="card h-100 border-0 hover-scale overflow-hidden shadow-sm transition-all">
          <!-- Conteneur image avec effet de zoom -->
          <div class="position-relative overflow-hidden image-zoom-container" style="height: 250px;">
            <img src="{{ $produit->getImageUrl() }}"
                 alt="{{ $produit->name }}"
                 class="img-fluid w-100 h-100 object-fit-cover transition-all zoom-image">
          
            <!-- Badge catégorie -->
            <div class="position-absolute top-0 start-0 m-3 text-white">
              <span class="badge bg-secondary">
                {{ $produit->categori->titre }}
              </span>
            </div>
          </div>

          <!-- Corps de la carte -->
          <div class="card-body p-3">
            <h5 class="fw-bold mb-2 text-truncate">{{ $produit->name }}</h5>

            <!-- Prix -->
            <div class="d-flex align-items-center justify-content-between border-top pt-3">
                <div>
                    <p class="mb-0">
                        <span class="badge bg-success" style="font-size: x-large;"><strong>{{ $produit->getPrice() }}</strong> FCFA</span>
                    </p>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-3">
                <button class="btn btn-sm btn-primary rounded-pill">
                    <i class="fas fa-cart-plus me-2"></i>Ajouter
                </button>
                <a href="{{ route('produit-detail', $produit->id) }}" wire:navigate class="btn btn-sm btn-dark rounded-pill">
                    <i class="fas fa-eye me-2"></i>Voir en détail
                </a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>