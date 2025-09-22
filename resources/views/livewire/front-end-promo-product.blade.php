<div class="container py-0">
    <div class="text-center mb-4">
        <div class="row g-4 bg-grey align-items-center mb-0" data-aos="fade-up">
            <div class="col-lg-4 text-start">
                <h1 class="display-5 fw-bold gradient-text">
                    <a href="{{ route('allPromoProduit') }}" style="text-decoration: none;">
                        <i class="fas fa-tags me-2"></i> En Promotion
                    </a>
                </h1>
            </div>
            <div class="col-lg-8 text-end">
                <div class="magnetic-wrap">
                    <!-- Bouton "Voir toutes les promotions" -->
                    <a href="{{ route('allPromoProduit') }}" 
                       class="btn cta-voir-plus magnetic-btn hover-lift">
                        <span class="btn-content">
                            <span class="btn-text">Voir toutes les promotions</span>
                            <i class="fas fa-arrow-right ms-2 arrow-icon"></i>
                        </span>
                        <div class="btn-shine"></div>
                        <div class="btn-glow"></div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Fallback noscript --}}
    <noscript>
        @foreach($produits as $produit)
            <div>
                <a href="{{ route('produit-detail', $produit->id) }}">
                    {{ $produit->name }} – {{ $produit->prix_promo }} FCFA
                </a>
            </div>
        @endforeach
    </noscript>

    {{-- JSON-LD SEO --}}
    <script type="application/ld+json">
    {
        "@context":"https://schema.org",
        "@type":"ItemList",
        "itemListElement":[
            @foreach($produits as $index => $p)
            {
                "@type":"ListItem",
                "position":{{ $index + 1 }},
                "url":"{{ route('produit-detail', $p->id) }}",
                "name":"{{ $p->name }}"
            }@if(!$loop->last),@endif
            @endforeach
        ]
    }
    </script>

    {{-- Carrousel Owl --}}
    <div wire:ignore>
        <div class="owl-carousel owl-theme" id="carouselProduitsPromo">
            @foreach($produits as $produit)
                <div class="item px-2">
                    <div class="card product-card h-100 border-0 rounded-4 shadow-sm">
                        <a href="{{ route('produit-detail', $produit->id) }}" 
                           class="card-image-link d-block text-decoration-none position-relative">
                            @php
                                $image1 = public_path('images/produits/'. $produit->image_produit);
                                $url = file_exists($image1)
                                        ? asset('images/produits/'. $produit->image_produit)
                                        : asset('storage/images/produits/' . $produit->image_produit);
                            @endphp

                            <img src="{{ $url }}" class="card-img-top img-fluid product-image" alt="{{ $produit->name }}" style="object-fit: cover; height: 250px;">

                            <!-- Badge Promotion -->
                            <div class="product-badge promo-badge">
                                <i class="fas fa-fire"></i> PROMO
                            </div>

                            <!-- Overlay -->
                            <div class="product-overlay">
                                <div class="overlay-content">
                                    <i class="fas fa-eye"></i>
                                    <span>Voir détails</span>
                                </div>
                            </div>
                        </a>

                        <div class="card-body p-3 text-center">
                            <h5 class="product-title fw-bold">{{ $produit->name }}</h5>

                            <!-- Prix -->
                            <div class="price-container mb-3">
                                <span class="price-original">{{ number_format($produit->price, 0, ',', ' ') }} FCFA</span>
                                <span class="price-promo animate-price">{{ number_format($produit->prix_promo, 0, ',', ' ') }} FCFA</span>
                                <div class="savings-badge">
                                    Économisez {{ number_format($produit->price - $produit->prix_promo, 0, ',', ' ') }} FCFA !
                                </div>
                            </div>

                            <!-- CTA -->
                            <div class="cta-container">
                                <button onclick="addPromoToCart({{ $produit->id }})" 
                                        class="btn cta-add-cart pulse-button">
                                    <span class="btn-content">
                                        <i class="fas fa-cart-plus cart-icon"></i>
                                        <span class="btn-text">Ajouter au panier</span>
                                    </span>
                                    <div class="btn-ripple"></div>
                                    <div class="success-check">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
    let promoCarouselInitialized = false;

    function initializePromoCarousel() {
        if (!promoCarouselInitialized) {
            $('#carouselProduitsPromo').owlCarousel({
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
            }).on('translated.owl.carousel', function() {
                AOS.refresh();
            });
            promoCarouselInitialized = true;
        }
    }

    function addPromoToCart(productId) {
        const button = event.target.closest('.cta-add-cart');
        button.classList.add('loading');

        @this.call('addToCart', productId).then(() => {
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
        initializePromoCarousel();
    });

    document.addEventListener('livewire:load', initializePromoCarousel);
    document.addEventListener('livewire:navigated', () => setTimeout(initializePromoCarousel, 100));
</script>
</div>


