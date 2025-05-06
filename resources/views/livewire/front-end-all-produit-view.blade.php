<div class="row justify-content-center">
    @foreach($produits as $produit)
    <div class="col-md-6 col-lg-4 col-xl-3 mb-4" wire:key="product-{{ $produit->id }}">
        <div class="card h-100 border-0 hover-scale overflow-hidden shadow-sm transition-all position-relative" 
             data-aos="fade-up"
             data-aos-delay="{{ $loop->index * 50 }}">
            
            <!-- Conteneur image avec effets avancés -->
            <a href="{{ route('produit-detail', $produit->id) }}" 
                class="card-image-link d-block text-decoration-none position-relative">
                <div class="position-relative overflow-hidden image-zoom-container" 
                    style="height: 250px;"
                    data-tilt data-tilt-max="10">
                    <img src="{{ $produit->getImageUrl() }}"
                        alt="{{ $produit->name }}"
                        class="img-fluid w-100 h-100 object-fit-cover transition-all zoom-image parallax-image"
                        data-parallax="hover">

                    <!-- Overlay interactif amélioré -->
                    <div class="image-overlay d-flex flex-column justify-content-between opacity-0 hover-opacity-100 transition-all">
                        <div class="d-flex justify-content-end p-3">
                            
                        </div>

                    </div>

                    <!-- Badge catégorie animé -->
                    <div class="position-absolute top-0 start-0 m-3">
                        <span class="badge bg-gradient-primary rounded-pill px-3 py-2 hover-lift">
                            {{ $produit->categori->titre }}
                        </span>
                    </div>

                    <!-- Effet de brillance au survol -->
                    <div class="shine-effect"></div>
                </div>
            </a>

            <!-- Corps de la carte amélioré -->
            <div class="card-body p-3 position-relative">
                <!-- Animation de fond -->
                <div class="card-glow"></div>

                <h5 class="fw-bold mb-2 text-truncate hover-lift">
                    {{ $produit->name }}
                </h5>

                <!-- Prix avec animation -->
                <div class="d-flex align-items-center justify-content-between border-top pt-3 price-container">
                    <div class="price-display">
                        <p class="mb-0 price-text">
                            <small class="text-muted">{{ $produit->getPrice() }}</small>
                        </p>
                    </div>
                </div>

                <!-- Bouton ajouter avec effet magnétique -->
                <div class="mt-3 position-relative magnetic-container">
                    <button class="btn btn-sm btn-primary rounded-pill magnetic-button" 
                            wire:click="addProductToCartAll({{ $produit->id }})"
                            >
                        <span class="button-content">
                            <i class="fas fa-cart-plus me-2"></i>Ajouter
                        </span>
                        <span class="button-loader spinner-border spinner-border-sm d-none"></span>
                    </button>
                    <div class="magnetic-ripple"></div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <style>
/* Animations principales */
.hover-scale {
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), 
                box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: transform;
}

.hover-scale:hover {
    transform: translateY(-8px) rotateX(2deg) rotateY(2deg);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
}

/* Effet parallaxe image */
.parallax-image {
    transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1), 
                filter 0.4s ease;
    transform-origin: center;
}

.parallax-image:hover {
    transform: scale(1.15) rotateZ(0.5deg);
    filter: brightness(1.05);
}

/* Overlay image */
.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.6) 100%);
}

/* Effet de brillance */
.shine-effect {
    position: absolute;
    top: 0;
    left: -100%;
    width: 50%;
    height: 100%;
    background: linear-gradient(
        90deg,
        rgba(255,255,255,0) 0%,
        rgba(255,255,255,0.3) 50%,
        rgba(255,255,255,0) 100%
    );
    transform: skewX(-30deg);
    transition: left 0.8s;
}

.image-zoom-container:hover .shine-effect {
    left: 150%;
}

/* Animation bouton */
.transform-down {
    transform: translateY(20px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.image-zoom-container:hover .transform-down {
    transform: translateY(0);
}

/* Effet magnétique */
.magnetic-button {
    position: relative;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}

.magnetic-container:hover .magnetic-button {
    transform: scale(1.05);
}

.magnetic-ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    transform: scale(0);
    pointer-events: none;
}

/* Animation prix */
.price-text {
    transition: transform 0.3s ease;
}

.price-container:hover .price-text {
    transform: translateY(-3px);
}

/* Glow effect */
.card-glow {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at var(--x) var(--y), 
        rgba(0,102,255,0.1) 0%, 
        transparent 70%);
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.3s;
}

.card:hover .card-glow {
    opacity: 1;
}
</style>

<script>
// Effet de suivi de souris
document.querySelectorAll('.card').forEach(card => {
    card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        card.style.setProperty('--x', `${x}px`);
        card.style.setProperty('--y', `${y}px`);
    });
});


</script>
</div>

