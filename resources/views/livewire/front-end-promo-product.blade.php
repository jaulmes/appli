
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
                    <div class="card product-card h-100 border-0 rounded-4 shadow-sm hover-card">
                        <a href="{{ route('produit-detail', $produit->id) }}" 
                           class="card-image-link d-block text-decoration-none position-relative">
                            
                            {{-- Image avec priorité GIF --}}
                            <div class="image-container position-relative">
                                <img src="{{ $this->getPriorityImage($produit) }}" 
                                     class="card-img-top img-fluid product-image" 
                                     alt="{{ $produit->name }}" 
                                     style="object-fit: cover; height: 250px;">

                                {{-- Badge GIF --}}
                                @if($this->isDisplayedImageGif($produit))
                                    <div class="gif-badge">
                                        <i class="fas fa-film me-1"></i>
                                        <span>GIF</span>
                                    </div>
                                @endif

                                {{-- Badge Promotion --}}
                                <div class="product-badge promo-badge">
                                    <i class="fas fa-fire"></i> PROMO
                                </div>

                                {{-- Indicateur photos multiples --}}
                                @if($this->getImageCount($produit) > 1)
                                    <div class="photos-count-badge">
                                        <i class="fas fa-images me-1"></i>
                                        {{ $this->getImageCount($produit) }}
                                    </div>
                                @endif

                                {{-- Badge économies --}}
                                <div class="savings-badge-top">
                                    -{{ round((($produit->price - $produit->prix_promo) / $produit->price) * 100) }}%
                                </div>

                                {{-- Overlay --}}
                                <div class="product-overlay">
                                    <div class="overlay-content">
                                        <i class="fas fa-eye"></i>
                                        <span>Voir détails</span>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <div class="card-body p-3 text-center">

                            <h5 class="product-title fw-bold mb-3">{{ Str::limit($produit->name, 45) }}</h5>

                            {{-- Prix --}}
                            <div class="price-container mb-3">
                                <span class="price-original">{{ number_format($produit->price, 0, ',', ' ') }} FCFA</span>
                                <span class="price-promo animate-price">{{ number_format($produit->prix_promo, 0, ',', ' ') }} FCFA</span>
                                <div class="savings-badge">
                                    <i class="fas fa-piggy-bank me-1"></i>
                                    Économisez {{ number_format($produit->price - $produit->prix_promo, 0, ',', ' ') }} FCFA !
                                </div>
                            </div>

                            

                            {{-- CTA --}}
                            <div class="cta-container">
                                <button onclick="addPromoToCart({{ $produit->id }})" 
                                        class="btn cta-add-cart pulse-button w-100">
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
    <style>
    /* === CARTE PRODUIT === */
    .hover-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15) !important;
    }

    .image-container {
        position: relative;
        overflow: hidden;
        border-radius: 15px 15px 0 0;
    }

    .product-image {
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-image-link:hover .product-image {
        transform: scale(1.1);
    }

    /* === BADGES === */
    .gif-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        z-index: 3;
        animation: gifPulse 2s ease-in-out infinite;
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
    }

    @keyframes gifPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .promo-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        padding: 8px 15px;
        border-radius: 25px;
        font-size: 13px;
        font-weight: 700;
        z-index: 3;
        animation: promoPulse 2s ease-in-out infinite;
        box-shadow: 0 4px 20px rgba(220, 53, 69, 0.5);
    }

    @keyframes promoPulse {
        0%, 100% { 
            transform: scale(1);
            box-shadow: 0 4px 20px rgba(220, 53, 69, 0.5);
        }
        50% { 
            transform: scale(1.08);
            box-shadow: 0 6px 25px rgba(220, 53, 69, 0.7);
        }
    }

    .photos-count-badge {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(10px);
        color: white;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 600;
        z-index: 3;
    }

    .savings-badge-top {
        position: absolute;
        top: 50px;
        left: 10px;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 700;
        z-index: 3;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
    }

    /* === OVERLAY === */
    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.4) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 2;
    }

    .card-image-link:hover .product-overlay {
        opacity: 1;
    }

    .overlay-content {
        text-align: center;
        color: white;
        transform: translateY(20px);
        transition: transform 0.3s ease;
    }

    .card-image-link:hover .overlay-content {
        transform: translateY(0);
    }

    .overlay-content i {
        font-size: 2rem;
        margin-bottom: 10px;
        display: block;
    }

    /* === PRIX === */
    .price-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .price-original {
        text-decoration: line-through;
        color: #999;
        font-size: 16px;
    }

    .price-promo {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        font-size: 22px;
        font-weight: 700;
        padding: 8px 20px;
        border-radius: 25px;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .animate-price {
        animation: priceGlow 2s ease-in-out infinite;
    }

    @keyframes priceGlow {
        0%, 100% { box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); }
        50% { box-shadow: 0 6px 25px rgba(40, 167, 69, 0.6); }
    }

    .savings-badge {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        color: white;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
        box-shadow: 0 3px 10px rgba(23, 162, 184, 0.3);
    }

    /* === BOUTON CTA === */
    .cta-add-cart {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
        color: white;
        padding: 12px 25px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .cta-add-cart:hover {
        background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(0, 123, 255, 0.4);
    }

    .pulse-button {
        animation: buttonPulse 2s ease-in-out infinite;
    }

    @keyframes buttonPulse {
        0%, 100% { box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3); }
        50% { box-shadow: 0 6px 25px rgba(0, 123, 255, 0.5); }
    }

    .btn-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .cart-icon {
        transition: transform 0.3s ease;
    }

    .cta-add-cart:hover .cart-icon {
        animation: cartShake 0.5s ease;
    }

    @keyframes cartShake {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(-10deg); }
        75% { transform: rotate(10deg); }
    }

    /* === ÉTATS DU BOUTON === */
    .btn-ripple {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: translate(-50%, -50%);
        z-index: 1;
    }

    .cta-add-cart.loading .btn-ripple {
        animation: rippleEffect 0.6s ease-out;
    }

    @keyframes rippleEffect {
        0% { width: 0; height: 0; opacity: 1; }
        100% { width: 200px; height: 200px; opacity: 0; }
    }

    .success-check {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        font-size: 24px;
        color: white;
        z-index: 3;
        opacity: 0;
    }

    .cta-add-cart.success .success-check {
        animation: checkAppear 0.5s ease forwards;
    }

    @keyframes checkAppear {
        0% { transform: translate(-50%, -50%) scale(0); opacity: 0; }
        50% { transform: translate(-50%, -50%) scale(1.3); opacity: 1; }
        100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
    }

    .cta-add-cart.success .btn-content {
        opacity: 0;
    }

    .cta-add-cart.success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .product-image {
            height: 200px !important;
        }

        .price-promo {
            font-size: 18px;
            padding: 6px 15px;
        }

        .product-title {
            font-size: 1rem;
        }

        .cta-add-cart {
            padding: 10px 20px;
            font-size: 14px;
        }
    }

    /* === ANIMATIONS D'ENTRÉE === */
    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .product-card {
        animation: fadeInScale 0.5s ease-out;
    }
</style>

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
                navText: [
                    '<i class="fas fa-chevron-left"></i>',
                    '<i class="fas fa-chevron-right"></i>'
                ],
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
            
            // Toast de confirmation
            showToast('Produit ajouté au panier avec succès !', 'success');
            
            setTimeout(() => {
                button.classList.remove('success');
            }, 2000);
        }).catch(() => {
            button.classList.remove('loading');
            button.classList.add('error');
            showToast('Erreur lors de l\'ajout au panier', 'error');
            setTimeout(() => {
                button.classList.remove('error');
            }, 2000);
        });
    }

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'times-circle'} me-2"></i>
            ${message}
        `;
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: ${type === 'success' ? 'linear-gradient(135deg, #28a745, #20c997)' : 'linear-gradient(135deg, #dc3545, #c82333)'};
            color: white;
            padding: 15px 25px;
            border-radius: 50px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            z-index: 9999;
            animation: slideInRight 0.5s ease;
            font-weight: 600;
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.5s ease';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }

    document.addEventListener('DOMContentLoaded', function(){
        AOS.init({ duration:800, once:true });
        initializePromoCarousel();
    });

    document.addEventListener('livewire:load', initializePromoCarousel);
    document.addEventListener('livewire:navigated', () => setTimeout(initializePromoCarousel, 100));

    // Écouter l'événement de produit ajouté
    window.addEventListener('ProduitAjoute', () => {
        showToast('Produit ajouté au panier !', 'success');
    });
</script>
</div>

