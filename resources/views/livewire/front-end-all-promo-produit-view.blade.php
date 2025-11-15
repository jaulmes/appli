<div class="row justify-content-center g-4">
    @foreach($produits as $produit)
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="card h-100 border-0 shadow-sm hover-scale transition-all position-relative overflow-hidden">

            <!-- IMAGE + OVERLAY -->
            <a href="{{ route('produit-detail', $produit->id) }}"
                class="d-block text-decoration-none position-relative">
                <div class="position-relative overflow-hidden image-zoom-container"
                    style="height: 260px;"
                    data-tilt data-tilt-max="8">

                    <!-- Image -->
                    <img src="{{ $produit->getImageUrl() }}"
                        alt="{{ $produit->name }}"
                        class="w-100 h-100 object-fit-cover zoom-image">

                    <!-- Badge catégorie -->
                    <span class="badge bg-primary text-white rounded-pill px-3 py-2 shadow glow-label position-absolute top-0 end-0 m-3 animate-badge">
                        <i class="fas fa-tag me-1"></i>
                        {{ $produit->categori->titre }}
                    </span>

                    <!-- Shine -->
                    <div class="shine-effect"></div>

                    <!-- Overlay icône -->
                    <div class="overlay-view d-flex align-items-center justify-content-center">
                        <div class="btn btn-light btn-lg rounded-circle shadow">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                </div>
            </a>

            <!-- CARD BODY -->
            <div class="card-body d-flex flex-column p-3">

                <!-- Nom -->
                <h5 class="fw-bold mb-2 text-truncate hover-primary">
                    {{ $produit->name }}
                </h5>

                <!-- Prix -->
                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                    <div>
                        <span class="badge bg-success fs-5 px-3 py-2 shadow-sm">
                            {{ number_format($produit->prix_promo, 0, ',', ' ') }} FCFA
                        </span>
                        <small class="text-muted ms-1">
                            <strike>{{ $produit->getPrice()}}</strike>
                        </small>
                    </div>
                </div>

                <!-- Bouton -->
                <div class="mt-3">
                    <button class="btn btn-primary btn-add-cart rounded-pill shadow-sm px-4"
                        wire:click="addToCart({{ $produit->id }})">
                        <i class="fas fa-cart-plus me-2"></i>
                        Ajouter
                    </button>
                </div>
            </div>

        </div>
    </div>
    @endforeach
    <style>/* === HOVER SCALE === */
.hover-scale {
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
}
.hover-scale:hover {
    transform: translateY(-8px);
    box-shadow: 0 18px 35px rgba(0,0,0,0.15) !important;
}

/* === IMAGE ZOOM === */
.image-zoom-container {
    transition: transform 0.3s;
    background: #f8f9fa;
}
.zoom-image {
    transition: transform 0.6s cubic-bezier(0.4,0,0.2,1);
}
.image-zoom-container:hover .zoom-image {
    transform: scale(1.15);
}

/* === OVERLAY VIEW === */
.overlay-view {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.35);
    opacity: 0;
    transition: opacity 0.3s ease;
}
.image-zoom-container:hover .overlay-view {
    opacity: 1;
}

/* === BADGE ANIMATION === */
.animate-badge {
    animation: wiggle 3s infinite ease-in-out;
}
@keyframes wiggle {
    0%,100% { transform: rotate(0deg); }
    25% { transform: rotate(-4deg); }
    75% { transform: rotate(4deg); }
}

/* === SHINE EFFECT === */
.shine-effect {
    position: absolute;
    top: 0;
    left: -150%;
    width: 120%;
    height: 100%;
    background: linear-gradient(120deg, transparent, rgba(255,255,255,0.4), transparent);
    transform: skewX(-25deg);
    transition: all 0.6s;
}
.image-zoom-container:hover .shine-effect {
    left: 120%;
}

/* === BUTTON ADD CART === */
.btn-add-cart {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    transition: all 0.3s ease;
}
.btn-add-cart:hover {
    background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%);
    transform: scale(1.05);
    box-shadow: 0 8px 20px rgba(40,167,69,0.3) !important;
}

/* === TEXT COLOR HOVER === */
.hover-primary:hover {
    color: #667eea !important;
}

/* === CARD ANIMATION ENTRY === */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(25px); }
    to   { opacity: 1; transform: translateY(0); }
}
.card {
    animation: fadeInUp 0.6s ease-out;
}
    </style>
</div>
