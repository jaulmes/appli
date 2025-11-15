<div class="container py-0">
    <div class="text-center mb-4">
        <div class="row g-4 bg-grey align-items-center mb-0" data-aos="fade-up">
            <div class="col-lg-4 text-start">
                <h1 class="display-5 fw-bold gradient-text">
                    <a href="{{ route('all-produit') }}" style="text-decoration: none;">
                        <i class="fas fa-box-open me-2"></i>Nos Produits
                    </a>
                </h1>
            </div>
            <div class="col-lg-8 text-end">
                <div class="magnetic-wrap">
                    <a href="{{ route('all-produit') }}" 
                       class="btn cta-voir-plus magnetic-btn hover-lift">
                        <span class="btn-content">
                            <span class="btn-text">Découvrir tous nos produits</span>
                            <i class="fas fa-arrow-right ms-2 arrow-icon"></i>
                        </span>
                        <div class="btn-shine"></div>
                        <div class="btn-glow"></div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Carrousel Owl --}}
    <div wire:ignore>
        <div class="owl-carousel owl-theme" id="carouselProduits">
            @foreach($produits as $produit)
                <div class="item px-2">
                    <div class="card product-card h-100 border-0 rounded-4 shadow-sm hover-lift-card">
                        <a href="{{ route('produit-detail', $produit->id) }}" 
                           class="card-image-link d-block text-decoration-none position-relative">
                            
                            {{-- Image avec priorité GIF --}}
                            <div class="image-wrapper position-relative">
                                <img src="{{ $this->getPriorityImage($produit) }}" 
                                     class="card-img-top img-fluid product-image" 
                                     alt="{{ $produit->name }}" 
                                     style="object-fit: cover; height: 250px;">
                                
                                {{-- Badge GIF --}}
                                @if($this->isDisplayedImageGif($produit))
                                    <div class="gif-badge position-absolute">
                                        <i class="fas fa-film me-1"></i>
                                        <span>GIF</span>
                                    </div>
                                @endif

                                {{-- Badge Promotion ou Nouveau --}}
                                @if($produit->status_promo)
                                    <div class="product-badge promo-badge">
                                        <i class="fas fa-fire"></i> PROMO
                                        <div class="badge-discount">
                                            -{{ round((($produit->price - $produit->prix_promo) / $produit->price) * 100) }}%
                                        </div>
                                    </div>
                                @else
                                    <div class="product-badge new-badge">
                                        <i class="fas fa-star"></i> NOUVEAU
                                    </div>
                                @endif
                                
                                {{-- Compteur photos --}}
                                @if($this->getImageCount($produit) > 1)
                                    <div class="photos-badge position-absolute">
                                        <i class="fas fa-images me-1"></i>
                                        {{ $this->getImageCount($produit) }}
                                    </div>
                                @endif

                                {{-- Overlay hover --}}
                                <div class="product-overlay">
                                    <div class="overlay-content">
                                        <i class="fas fa-eye mb-2"></i>
                                        <span class="d-block">Voir détails</span>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <div class="card-body p-3 text-center">

                            {{-- Titre --}}
                            <h5 class="product-title fw-bold mb-3">{{ Str::limit($produit->name, 45) }}</h5>
                            
                            {{-- Prix avec animation --}}
                            <div class="price-container mb-3">
                                @if($produit->status_promo)
                                    <span class="price-original">{{ number_format($produit->price, 0, ',', ' ') }} FCFA</span>
                                    <span class="price-promo animate-price">{{ number_format($produit->prix_promo, 0, ',', ' ') }} FCFA</span>
                                    <div class="savings-badge mt-2">
                                        <i class="fas fa-piggy-bank me-1"></i>
                                        Économisez {{ number_format($produit->price - $produit->prix_promo, 0, ',', ' ') }} FCFA!
                                    </div>
                                @else
                                    <span class="price-normal animate-price">{{ $produit->getPrice() }}</span>
                                @endif
                            </div>
                            
                            
                            
                            {{-- Bouton d'achat --}}
                            <div class="cta-container">
                                @if($produit->stock > 0)
                                    <button onclick="addProduitToCart({{ $produit->id }})" 
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
                                @else
                                    <button onclick="addProduitToCart({{ $produit->id }})" 
                                            class="btn cta-notify w-100">
                                        <span class="btn-content">
                                            <i class="fas fa-bell bell-icon"></i>
                                            <span class="btn-text">Reserver</span>
                                        </span>
                                        <div class="btn-ripple"></div>
                                        <div class="success-check">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <style>
/* === CARTES PRODUITS === */
.hover-lift-card {
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.hover-lift-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}

.image-wrapper {
    overflow: hidden;
    border-radius: 15px 15px 0 0;
    background: #f8f9fa;
}

.product-image {
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.card-image-link:hover .product-image {
    transform: scale(1.15) rotate(2deg);
}

/* === BADGES === */
.gif-badge {
    top: 10px;
    right: 10px;
    background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    z-index: 4;
    animation: gifBounce 2s ease-in-out infinite;
    box-shadow: 0 4px 15px rgba(255, 193, 7, 0.5);
}

@keyframes gifBounce {
    0%, 100% { transform: scale(1) rotate(0deg); }
    50% { transform: scale(1.1) rotate(-5deg); }
}

.product-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 3;
    padding: 8px 15px;
    border-radius: 25px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    animation: badgeFloat 3s ease-in-out infinite;
}

.promo-badge {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    box-shadow: 0 5px 20px rgba(220, 53, 69, 0.5);
}

.new-badge {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    box-shadow: 0 5px 20px rgba(40, 167, 69, 0.5);
}

@keyframes badgeFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

.badge-discount {
    background: rgba(255, 255, 255, 0.3);
    padding: 2px 6px;
    border-radius: 10px;
    font-size: 10px;
    margin-left: 5px;
    display: inline-block;
}

.photos-badge {
    bottom: 10px;
    left: 10px;
    background: rgba(0, 0, 0, 0.75);
    backdrop-filter: blur(10px);
    color: white;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 11px;
    font-weight: 600;
    z-index: 3;
}

.category-badge {
    font-size: 11px;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 15px;
    transition: all 0.3s ease;
}

.category-badge:hover {
    transform: scale(1.05);
}

/* === OVERLAY === */
.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.5) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.4s ease;
    z-index: 2;
}

.card-image-link:hover .product-overlay {
    opacity: 1;
}

.overlay-content {
    text-align: center;
    color: white;
    transform: translateY(20px) scale(0.9);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.card-image-link:hover .overlay-content {
    transform: translateY(0) scale(1);
}

.overlay-content i {
    font-size: 2.5rem;
    animation: eyePulse 2s ease-in-out infinite;
}

@keyframes eyePulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

/* === TITRE === */
.product-title {
    color: #2c3e50;
    font-size: 1.05rem;
    transition: color 0.3s ease;
    line-height: 1.4;
    min-height: 45px;
}

.product-card:hover .product-title {
    color: #667eea;
}

/* === PRIX === */
.price-container {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
}

.price-original {
    text-decoration: line-through;
    color: #95a5a6;
    font-size: 14px;
}

.price-promo {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    font-weight: 700;
    font-size: 1.3rem;
    padding: 8px 20px;
    border-radius: 25px;
    display: inline-block;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.price-normal {
    color: #667eea;
    font-weight: 700;
    font-size: 1.25rem;
}

.animate-price {
    animation: priceAppear 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes priceAppear {
    0% { transform: scale(0.5); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

.savings-badge {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    color: white;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
    box-shadow: 0 3px 10px rgba(23, 162, 184, 0.3);
    animation: savingsPulse 2s ease-in-out infinite;
}

@keyframes savingsPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* === STOCK === */
.stock-indicator {
    font-size: 0.85rem;
}

.stock-limited {
    animation: stockBlink 1.5s ease-in-out infinite;
}

@keyframes stockBlink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* === BOUTONS CTA === */
.cta-add-cart {
    position: relative;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 30px;
    padding: 14px 25px;
    color: white;
    font-weight: 600;
    font-size: 15px;
    overflow: hidden;
    transition: all 0.4s ease;
    animation: buttonBreathe 3s ease-in-out infinite;
}

.cta-add-cart:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    transform: scale(1.05);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    color: white;
}

.pulse-button {
    animation: buttonBreathe 3s ease-in-out infinite;
}

@keyframes buttonBreathe {
    0%, 100% { 
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
    }
    50% { 
        box-shadow: 0 8px 30px rgba(102, 126, 234, 0.5);
    }
}

.btn-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.cart-icon {
    transition: transform 0.3s ease;
}

.cta-add-cart:hover .cart-icon {
    animation: cartJump 0.6s ease;
}

@keyframes cartJump {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px) rotate(-10deg); }
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
    animation: rippleExpand 0.6s ease-out;
}

@keyframes rippleExpand {
    0% { width: 0; height: 0; opacity: 1; }
    100% { width: 250px; height: 250px; opacity: 0; }
}

.success-check {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0);
    font-size: 1.5rem;
    color: white;
    z-index: 3;
    opacity: 0;
}

.cta-add-cart.success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.cta-add-cart.success .success-check {
    animation: checkPop 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
}

@keyframes checkPop {
    0% { transform: translate(-50%, -50%) scale(0); opacity: 0; }
    50% { transform: translate(-50%, -50%) scale(1.3); opacity: 1; }
    100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
}

.cta-add-cart.success .btn-content {
    opacity: 0;
}

/* === BOUTON NOTIFIER === */
.cta-notify {
    background: linear-gradient(135deg, #fd7e14 0%, #dc3545 100%);
    border: none;
    border-radius: 30px;
    padding: 14px 25px;
    color: white;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease;
}

.cta-notify:hover {
    background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
    transform: scale(1.05);
    box-shadow: 0 10px 30px rgba(220, 53, 69, 0.4);
    color: white;
}

.bell-icon {
    animation: bellRing 2s ease-in-out infinite;
}

@keyframes bellRing {
    0%, 100% { transform: rotate(0deg); }
    10%, 30% { transform: rotate(-15deg); }
    20%, 40% { transform: rotate(15deg); }
}

/* === BOUTON VOIR PLUS === */
.cta-voir-plus {
    position: relative;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 50px;
    padding: 15px 35px;
    color: white;
    font-weight: 600;
    text-decoration: none;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    animation: gentlePulse 3s ease-in-out infinite;
    display: inline-block;
}

.cta-voir-plus:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
    color: white;
}

.arrow-icon {
    transition: transform 0.3s ease;
}

.cta-voir-plus:hover .arrow-icon {
    transform: translateX(8px);
}

@keyframes gentlePulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.02); }
}

.btn-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    transition: left 0.6s;
    z-index: 1;
}

.cta-voir-plus:hover .btn-shine {
    left: 100%;
}

/* === RESPONSIVE === */
@media (max-width: 768px) {
    .product-image {
        height: 200px !important;
    }
    
    .product-title {
        font-size: 0.95rem;
        min-height: 40px;
    }
    
    .price-promo {
        font-size: 1.1rem;
        padding: 6px 15px;
    }
    
    .cta-add-cart, .cta-notify {
        padding: 12px 20px;
        font-size: 14px;
    }
    
    .cta-voir-plus {
        padding: 12px 25px;
        font-size: 14px;
    }
}
</style>

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
                autoplayTimeout: 3500,
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
                if (typeof AOS !== 'undefined') {
                    AOS.refresh();
                }
            });
            produitsCarouselInitialized = true;
        }
    }

    function addProduitToCart(productId) {
        const button = event.target.closest('.cta-add-cart');
        button.classList.add('loading');
        
        @this.call('addProductToCart', productId).then(() => {
            button.classList.remove('loading');
            button.classList.add('success');
            
            showToast('Produit ajouté au panier avec succès !', 'success');
            
            setTimeout(() => button.classList.remove('success'), 2000);
        }).catch(() => {
            button.classList.remove('loading');
            showToast('Erreur lors de l\'ajout au panier', 'error');
        });
    }

    function notifyWhenAvailable(productId) {
        showToast('Vous serez averti dès que ce produit sera disponible !', 'info');
        // Ici vous pouvez ajouter l'appel pour enregistrer la notification
    }

    function showToast(message, type = 'success') {
        const icons = {
            success: 'check-circle',
            error: 'times-circle',
            info: 'info-circle'
        };
        
        const colors = {
            success: 'linear-gradient(135deg, #28a745, #20c997)',
            error: 'linear-gradient(135deg, #dc3545, #c82333)',
            info: 'linear-gradient(135deg, #17a2b8, #138496)'
        };
        
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: ${colors[type]};
            color: white;
            padding: 15px 25px;
            border-radius: 50px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            z-index: 9999;
            animation: slideInRight 0.5s ease;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        `;
        toast.innerHTML = `<i class="fas fa-${icons[type]}"></i>${message}`;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.5s ease';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }

    $(document).ready(initializeProduitsCarousel);
    document.addEventListener('livewire:load', initializeProduitsCarousel);
    document.addEventListener('livewire:navigated', () => setTimeout(initializeProduitsCarousel, 100));

    // Écouter l'événement de produit ajouté
    window.addEventListener('ProduitAjoute', () => {
        showToast('Produit ajouté au panier !', 'success');
    });

    // Animations CSS personnalisées
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
</script>
<script>
    $(document).ready(function(){
        $('#carouselProduits').owlCarousel({
            loop: true,               // boucle infinie
            margin: 15,               // marge entre les éléments
            nav: false,               // pas de boutons précédent/suivant
            dots: false,              // cacher les points
            autoplay: true,           // défilement automatique
            autoplayTimeout: 2500,    // chaque 2.5 secondes
            autoplayHoverPause: true, // pause quand la souris passe dessus
            autoplaySpeed: 800,       // vitesse de transition
            responsive:{
                0:{ items: 1.2 },     // mobile : 1 produit visible + défilement fluide
                480:{ items: 1.5 },
                768:{ items: 2.5 },   // tablette
                1024:{ items: 3.5 },  // desktop
                1280:{ items: 4 }     // grands écrans
            }
        });
    });
</script>

</div>

