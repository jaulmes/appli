<div>
    <div>
        <div class="row g-4">
            @forelse($produits as $produit)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100 border-0 shadow-sm hover-scale transition-all position-relative">
                    <!-- Badge promo -->
                    @if($produit->status_promo)
                    <div class="position-absolute top-0 start-0 m-3" style="z-index: 10;">
                        <span class="badge bg-danger px-3 py-2 rounded-pill shadow-sm animate-pulse">
                            <i class="fas fa-fire me-1"></i>
                            PROMO
                        </span>
                    </div>
                    @endif

                    

            <!-- Image avec zoom -->
            <a href="{{ route('produit-detail', $produit->id) }}" class="text-decoration-none">
                <div class="image-zoom-container position-relative" style="height: 280px; overflow: hidden;">
                    <img src="{{ $this->getPriorityImage($produit) }}"
                        class="card-img-top zoom-image w-100 h-100"
                        alt="{{ $produit->name }}"
                        style="object-fit: cover;"
                        loading="lazy">

                    <!-- Overlay sombre au hover -->
                    <div class="card-img-overlay d-flex align-items-center justify-content-center opacity-0 hover-opacity-100 transition-all">
                        <span class="btn btn-light btn-lg rounded-circle shadow">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>
            </a>

            <!-- Corps de la carte -->
            <div class="card-body d-flex flex-column">
                <!-- Nom du produit -->
                <h5 class="card-title fw-bold mb-3" style="min-height: 50px;">
                    <a href="{{ route('produit-detail', $produit->id) }}"
                        class="text-dark text-decoration-none hover-primary">
                        {{ Str::limit($produit->name, 50) }}
                    </a>
                </h5>

                <!-- Prix -->
                <div class="mb-3">
                    @if($produit->status_promo)
                    <div class="d-flex align-items-center gap-2">
                        <del class="text-muted small">{{ number_format($produit->price, 0, ',', ' ') }} FCFA</del>
                        <span class="badge bg-success fs-5 px-3 py-2">
                            {{ number_format($produit->prix_promo, 0, ',', ' ') }} FCFA
                        </span>
                    </div>
                    @else
                    <span class="badge bg-success fs-5 px-3 py-2">
                        {{ number_format($produit->price, 0, ',', ' ') }} FCFA
                    </span>
                    @endif
                </div>


                <!-- Boutons d'action -->
                <div class="mt-auto d-flex gap-2">
                    @if($produit->stock > 0)
                    <button wire:click="addProductToCartAll({{ $produit->id }})"
                        class="btn btn-primary flex-grow-1 rounded-pill shadow-sm btn-add-cart">
                        <i class="fas fa-cart-plus me-2"></i>
                        Ajouter
                    </button>
                    @else
                    <button wire:click="addProductToCartAll({{ $produit->id }})"
                        class="btn btn-warning flex-grow-1 rounded-pill shadow-sm btn-reserve">
                        <i class="fas fa-bolt me-2"></i>
                        Réserver
                    </button>
                    @endif

                    <a href="{{ route('produit-detail', $produit->id) }}"
                        class="btn btn-outline-secondary rounded-circle shadow-sm btn-view">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>

                <!-- Indicateur d'images multiples -->
                @if($produit->images && $produit->images->count() > 1)
                <div class="mt-2 text-center">
                    <small class="text-muted">
                        <i class="fas fa-images me-1"></i>
                        {{ $produit->images->count() }} photos
                    </small>
                </div>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center py-5 rounded-3 shadow-sm">
            <i class="fas fa-box-open fs-1 mb-3 d-block"></i>
            <h4>Aucun produit disponible</h4>
            <p class="mb-0 text-muted">Revenez plus tard pour découvrir nos nouveautés !</p>
        </div>
    </div>
    @endforelse
</div>

<!-- Indication de chargement -->
<div wire:loading class="text-center py-5">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Chargement...</span>
    </div>
    <p class="mt-3 text-muted">Chargement des produits...</p>
</div>
<style>
    /* === ANIMATIONS === */
    .animate-pulse {
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    .animate-badge {
        animation: badgeWiggle 3s ease-in-out infinite;
    }

    @keyframes badgeWiggle {

        0%,
        100% {
            transform: rotate(0deg);
        }

        25% {
            transform: rotate(-5deg);
        }

        75% {
            transform: rotate(5deg);
        }
    }

    /* === HOVER EFFECTS === */
    .hover-primary:hover {
        color: #667eea !important;
        transition: color 0.3s ease;
    }

    .hover-scale {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hover-scale:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12) !important;
    }

    /* === IMAGE ZOOM === */
    .image-zoom-container {
        transition: transform 0.3s;
        overflow: hidden;
        background: #f8f9fa;
    }

    .zoom-image {
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .image-zoom-container:hover .zoom-image {
        transform: scale(1.15);
    }

    /* === OVERLAY === */
    .card-img-overlay {
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.2) 50%);
        z-index: 2;
    }

    .hover-opacity-100:hover {
        opacity: 1 !important;
    }

    .transition-all {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* === BOUTONS === */
    .btn-add-cart {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-add-cart:hover {
        background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%);
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3) !important;
    }

    .btn-add-cart:active {
        transform: scale(0.95);
    }

    .btn-reserve {
        background: linear-gradient(135deg, #fd7e14 0%, #dc3545 100%);
        border: none;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-reserve:hover {
        background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3) !important;
        color: white;
    }

    .btn-view {
        transition: all 0.3s ease;
    }

    .btn-view:hover {
        background: #667eea;
        color: white;
        border-color: #667eea;
        transform: scale(1.1);
    }

    /* === CARTES === */
    .card {
        border-radius: 15px !important;
        overflow: hidden;
    }

    .card-body {
        padding: 1.25rem;
    }

    /* === BADGES === */
    .badge {
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .image-zoom-container {
            height: 200px !important;
        }

        .card-title {
            font-size: 1rem;
            min-height: 40px !important;
        }

        .btn-add-cart,
        .btn-reserve {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
        }
    }

    @media (max-width: 576px) {
        .col-sm-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    /* === ANIMATION D'ENTRÉE === */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeInUp 0.5s ease-out;
    }

    /* Délai progressif pour l'animation */
    .col-lg-3:nth-child(1) .card {
        animation-delay: 0.1s;
    }

    .col-lg-3:nth-child(2) .card {
        animation-delay: 0.2s;
    }

    .col-lg-3:nth-child(3) .card {
        animation-delay: 0.3s;
    }

    .col-lg-3:nth-child(4) .card {
        animation-delay: 0.4s;
    }
</style>

<script>
    // Toast de notification après ajout au panier
    window.addEventListener('ProduitAjoute', event => {
        // Créer un toast Bootstrap ou une notification
        const toast = document.createElement('div');
        toast.className = 'position-fixed bottom-0 end-0 p-3';
        toast.style.zIndex = '11';
        toast.innerHTML = `
                <div class="toast show" role="alert">
                    <div class="toast-header bg-success text-white">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong class="me-auto">Succès</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        Produit ajouté au panier avec succès !
                    </div>
                </div>
            `;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    });
</script>
</div>