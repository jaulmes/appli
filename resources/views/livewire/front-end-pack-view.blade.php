<div class="container py-0">
    <div class="text-center mb-4">
        <div class="row g-4 bg-grey align-items-center mb-0" data-aos="fade-up">
            <div class="col-lg-4 text-start">
                <h1 class="display-5 fw-bold gradient-text">
                    <a href="{{ route('all-pack') }}" style="text-decoration: none;">
                        <i class="fas fa-box-open me-2"></i> Nos Packs
                    </a>
                </h1>
            </div>
            <div class="col-lg-8 text-end">
                <div class="magnetic-wrap">
                    <!-- Bouton CTA -->
                    <a href="{{ route('all-pack') }}" 
                       class="btn cta-voir-plus magnetic-btn hover-lift">
                        <span class="btn-content">
                            <span class="btn-text">Voir tous les packs</span>
                            <i class="fas fa-arrow-right ms-2 arrow-icon"></i>
                        </span>
                        <div class="btn-shine"></div>
                        <div class="btn-glow"></div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Fallback si JS désactivé --}}
    <noscript>
        @foreach($packs as $pack)
            <div>
                <a href="{{ route('detail-pack', $pack->id) }}">
                    {{ $pack->titre }} – {{ number_format($pack->prix, 0, ',', ' ') }} FCFA
                </a>
            </div>
        @endforeach
    </noscript>

    {{-- Carrousel Owl --}}
    <div wire:ignore>
        <div class="owl-carousel owl-theme" id="carouselPacks">
            @foreach($packs as $pack)
                <div class="item px-2">
                    <div class="card product-card h-100 border-0 rounded-4 shadow-sm">
                        <a href="{{ route('detail-pack', $pack->id) }}" 
                           class="card-image-link d-block text-decoration-none position-relative">
                            @php
                                $image1 = public_path('images/packs/'. $pack->image);
                                $url = file_exists($image1)
                                        ? asset('images/packs/'. $pack->image)
                                        : asset('storage/images/packs/' . $pack->image);
                            @endphp

                            <img src="{{ $url }}" class="card-img-top img-fluid product-image" alt="{{ $pack->titre }}" style="object-fit: cover; height: 250px;">

                            <!-- Badge pack -->
                            <div class="product-badge pack-badge">
                                <i class="fas fa-gift"></i> PACK
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
                            <h5 class="product-title fw-bold">{{ $pack->titre }}</h5>

                            <!-- Prix -->
                            <div class="price-container mb-3">
                                <span class="price-promo animate-price">
                                    {{ number_format($pack->prix, 0, ',', ' ') }} FCFA
                                </span>
                            </div>

                            <!-- CTA -->
                            <div class="cta-container">
                                <button onclick="addPackToCart({{ $pack->id }})" 
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
    let packsCarouselInitialized = false;

    function initializePacksCarousel() {
        if (!packsCarouselInitialized) {
            $('#carouselPacks').owlCarousel({
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
            packsCarouselInitialized = true;
        }
    }

    function addPackToCart(packId) {
        const button = event.target.closest('.cta-add-cart');
        button.classList.add('loading');

        @this.call('addPackToCart', packId).then(() => {
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
        initializePacksCarousel();
    });

    document.addEventListener('livewire:load', initializePacksCarousel);
    document.addEventListener('livewire:navigated', () => setTimeout(initializePacksCarousel, 100));
</script>
</div>


