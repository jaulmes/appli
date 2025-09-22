<div class="container py-0">
    <div class="text-center mb-4">
        <div class="row g-4 align-items-center mb-0" data-aos="fade-up">
            <div class="col-lg-4 text-start">
                <h1 class="display-5 fw-bold gradient-text">
                    <i class="fas fa-box-open me-2"></i> Nos Produits
                </h1>
            </div>
            <div class="col-lg-8 text-end">
                <div class="magnetic-wrap">
                    <a href="{{ route('all-produits') }}" class="btn cta-voir-plus magnetic-btn hover-lift">
                        <span class="btn-content">
                            <span class="btn-text">Voir tous les produits</span>
                            <i class="fas fa-arrow-right ms-2 arrow-icon"></i>
                        </span>
                        <div class="btn-shine"></div>
                        <div class="btn-glow"></div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($produits->isEmpty())
        <div class="alert alert-warning text-center">
            Aucun produit disponible pour le moment.
        </div>
    @else
        <div wire:ignore>
            <div class="owl-carousel owl-theme" id="carouselProduits">
                @foreach($produits as $produit)
                    <div class="item px-2">
                        <div class="card product-card h-100 border-0 rounded-4 shadow-sm hover-3d">
                            <!-- Conteneur image avec overlay -->
                            <a href="{{ route('produit-detail', $produit->id) }}" class="card-image-link d-block position-relative text-decoration-none">
                                <img src="{{ $produit->getImageUrl() }}" 
                                     alt="{{ $produit->name }}" 
                                     class="card-img-top img-fluid product-image zoom-image" 
                                     style="object-fit: cover; height: 250px;">

                                <!-- Badge catégorie -->
                                <div class="product-badge pack-badge">
                                    {{ $produit->categori->titre }}
                                </div>

                                <!-- Overlay -->
                                <div class="product-overlay">
                                    <div class="overlay-content">
                                        <i class="fas fa-eye"></i>
                                        <span>Voir détails</span>
                                    </div>
                                </div>
                            </a>

                            <!-- Corps de la carte -->
                            <div class="card-body p-3 text-center d-flex flex-column">
                                <h5 class="product-title fw-bold text-truncate">{{ $produit->name }}</h5>

                                <!-- Prix -->
                                <div class="price-container mb-3">
                                    <span class="price-promo animate-price">
                                        {{ $produit->getPrice() }} FCFA
                                    </span>
                                </div>

                                <!-- CTA -->
                                <div class="cta-container mt-auto">
                                    <button onclick="addProductToCart({{ $produit->id }})" 
                                            class="btn cta-add-cart pulse-button">
                                        <span class="btn-content">
                                            <i class="fas fa-cart-plus cart-icon"></i>
                                            <span class="btn-text">Ajouter au panier</span>
                                        </span>
                                        <div class="btn-ripple"></div>
                                        <div class="success-check"><i class="fas fa-check"></i></div>
                                    </button>
                                    <a href="{{ route('produit-detail', $produit->id) }}" 
                                       class="btn btn-dark rounded-pill mt-2 d-inline-block">
                                        <i class="fas fa-eye me-2"></i>Voir en détail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <script>
    let produitsCarouselInitialized = false;

    function initializeProduitsCarousel() {
        if (!produitsCarouselInitialized) {
            $('#carouselProduits').owlCarousel({
                loop: true,
                margin: 15,
                nav: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: true,
                responsive:{
                    0:{ items:1 },
                    576:{ items:2 },
                    768:{ items:3 },
                    992:{ items:4 }
                }
            }).on('translated.owl.carousel', function() { AOS.refresh(); });
            produitsCarouselInitialized = true;
        }
    }

    function addProductToCart(productId) {
        const button = event.target.closest('.cta-add-cart');
        button.classList.add('loading');

        @this.call('addProductToCart', productId).then(() => {
            button.classList.remove('loading');
            button.classList.add('success');
            setTimeout(() => button.classList.remove('success'), 2000);
        }).catch(() => {
            button.classList.remove('loading');
            button.classList.add('error');
            setTimeout(() => button.classList.remove('error'), 2000);
        });
    }

    document.addEventListener('DOMContentLoaded', function(){
        AOS.init({ duration:800, once:true });
        initializeProduitsCarousel();
    });

    document.addEventListener('livewire:load', initializeProduitsCarousel);
    document.addEventListener('livewire:navigated', () => setTimeout(initializeProduitsCarousel, 100));
    </script>
</div>
