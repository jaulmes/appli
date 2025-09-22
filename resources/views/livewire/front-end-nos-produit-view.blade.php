<div class="container py-0">
    <div class="text-center mb-4">
        <div class="row g-4 bg-grey align-items-center mb-0" data-aos="fade-up">
            <div class="col-lg-4 text-start">
                <h1 class="display-5 fw-bold gradient-text">
                    <a href="{{ route('all-produit') }}" style="text-decoration: none;">Nos Produits</a>
                </h1>
            </div>
            <div class="col-lg-8 text-end">
                <div class="magnetic-wrap">
                    <!-- Bouton "Voir plus" amélioré -->
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

    {{-- Utiliser wire:ignore pour empêcher Livewire de re-rendre cette section --}}
    <div wire:ignore>
        <div class="owl-carousel owl-theme" id="carouselProduits">
            @foreach($produits as $produit)
                <div class="item px-2">
                    <div class="card product-card h-100 border-0 rounded-4 shadow-sm">
                        <a href="{{ route('produit-detail', $produit->id) }}" class="card-image-link d-block text-decoration-none position-relative">
                            @php
                                $image1 = public_path('images/produits/'. $produit->image_produit);
                                $image2 = public_path('storage/images/produits/'. $produit->image_produit);
                                $url = file_exists($image1) ? asset('images/produits/'. $produit->image_produit)
                                                           : asset('storage/images/produits/' . $produit->image_produit);
                            @endphp

                            <img src="{{ $url }}" class="card-img-top img-fluid product-image" alt="{{ $produit->name }}" style="object-fit: cover; height: 250px;">
                            
                            <!-- Badge de promotion ou nouveau produit -->
                            @if($produit->status_promo)
                                <div class="product-badge promo-badge">
                                    <i class="fas fa-fire"></i> PROMO
                                </div>
                            @else
                                <div class="product-badge new-badge">
                                    <i class="fas fa-star"></i> NOUVEAU
                                </div>
                            @endif
                            
                            <!-- Overlay avec effet hover -->
                            <div class="product-overlay">
                                <div class="overlay-content">
                                    <i class="fas fa-eye"></i>
                                    <span>Voir détails</span>
                                </div>
                            </div>
                        </a>

                        <div class="card-body p-3 text-center">
                            <h5 class="product-title fw-bold">{{ $produit->name }}</h5>
                            
                            <!-- Prix avec animation -->
                            <div class="price-container mb-3">
                                @if($produit->status_promo)
                                    <span class="price-original">{{ number_format($produit->price, 0, ',', ' ') }} FCFA</span>
                                    <span class="price-promo animate-price">{{ number_format($produit->prix_promo, 0, ',', ' ') }} FCFA</span>
                                    <div class="savings-badge">
                                        Économisez {{ number_format($produit->price - $produit->prix_promo, 0, ',', ' ') }} FCFA!
                                    </div>
                                @else
                                    <span class="price-normal animate-price">{{ $produit->getPrice() }}</span>
                                @endif
                            </div>
                            
                            <!-- Stock indicator -->
                            <div class="stock-indicator mb-2">
                                @if($produit->stock > 10)
                                    <span class="stock-good">
                                        <i class="fas fa-check-circle"></i> En stock
                                    </span>
                                @else
                                    <span class="stock-limited">
                                        <i class="fas fa-exclamation-triangle"></i> Stock limité 
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Bouton d'achat amélioré -->
                            <div class="cta-container">
                                <button onclick="addProduitToCart({{ $produit->id }})" 
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
        let produitsCarouselInitialized = false;

        function initializeProduitsCarousel() {
            if (!produitsCarouselInitialized) {
                $('#carouselProduits').owlCarousel({
                    loop: true,
                    margin: 15,
                    nav: true,
                    dots: false,
                    autoplay: true,
                    autoplayTimeout: 3000, // Augmenté pour une meilleure UX
                    autoplayHoverPause: true,
                    responsive:{
                        0:{ items:1 },
                        576:{ items:2 },
                        768:{ items:3 },
                        992:{ items:4 }
                    }
                });
                produitsCarouselInitialized = true;
            }
        }

        function addProduitToCart(productId) {
            const button = event.target.closest('.cta-add-cart');
            
            // Animation de chargement
            button.classList.add('loading');
            
            // Appeler la méthode Livewire
            @this.call('addProductToCart', productId).then(() => {
                // Animation de succès
                button.classList.remove('loading');
                button.classList.add('success');
                
                // Retirer l'état de succès après 2 secondes
                setTimeout(() => {
                    button.classList.remove('success');
                }, 2000);
            }).catch(() => {
                button.classList.remove('loading');
                button.classList.add('error');
                
                setTimeout(() => {
                    button.classList.remove('error');
                }, 2000);
            });
        }

        function toggleFavorite(productId) {
            const button = event.target.closest('.btn-favorite');
            const icon = button.querySelector('.heart-icon');
            
            button.classList.toggle('active');
            
            if (button.classList.contains('active')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                button.style.color = '#e74c3c';
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                button.style.color = '';
            }
            
            // Ici vous pouvez ajouter l'appel AJAX pour sauvegarder en favoris
        }

        function notifyWhenAvailable(productId) {
            // Logique pour s'inscrire aux notifications
            alert('Vous serez averti dès que ce produit sera disponible !');
        }

        // Initialiser au chargement de la page
        $(document).ready(function(){
            initializeProduitsCarousel();
        });

        // Réinitialiser après les mises à jour Livewire
        document.addEventListener('livewire:load', function () {
            initializeProduitsCarousel();
        });

        document.addEventListener('livewire:navigated', function () {
            setTimeout(() => {
                initializeProduitsCarousel();
            }, 100);
        });

        // Écouter les événements de mise à jour du panier
        window.addEventListener('product-added-to-cart', function(event) {
            console.log('Produit ajouté au panier:', event.detail.message);
            
            // Notification toast
            if (typeof toastr !== 'undefined') {
                toastr.success(event.detail.message);
            }
            
            updateCartCounter();
        });
    </script>
    <style>
/* === STYLES POUR LES CTA AMÉLIORÉS === */

/* Bouton "Voir plus" amélioré */
.cta-voir-plus {
    position: relative;
    background: linear-gradient(135deg, #2ecc71 0%, #3498db 100%);
    border: none;
    border-radius: 50px;
    padding: 15px 30px;
    color: white;
    font-weight: 600;
    text-decoration: none;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 10px 30px rgba(46, 204, 113, 0.3);
    animation: gentlePulse 3s ease-in-out infinite;
}

.cta-voir-plus:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 20px 40px rgba(46, 204, 113, 0.4);
    color: white;
}

.cta-voir-plus .arrow-icon {
    transition: transform 0.3s ease;
}

.cta-voir-plus:hover .arrow-icon {
    transform: translateX(5px);
    animation: arrowBounce 0.6s ease-in-out;
}

@keyframes gentlePulse {
    0%, 100% { 
        transform: scale(1);
        box-shadow: 0 10px 30px rgba(46, 204, 113, 0.3);
    }
    50% { 
        transform: scale(1.02);
        box-shadow: 0 15px 35px rgba(46, 204, 113, 0.4);
    }
}

@keyframes arrowBounce {
    0%, 100% { transform: translateX(5px) scale(1); }
    50% { transform: translateX(8px) scale(1.1); }
}

/* Card produit améliorée */
.product-card {
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}

.product-image {
    transition: transform 0.5s ease;
}

.product-card:hover .product-image {
    transform: scale(1.1);
}

/* Badge produit */
.product-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 10;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    animation: badgePulse 2s ease-in-out infinite;
}

.promo-badge {
    background: linear-gradient(135deg, #f1c40f, #f39c12);
    color: white;
    box-shadow: 0 4px 15px rgba(241, 196, 15, 0.4);
}

.new-badge {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
    color: white;
    box-shadow: 0 4px 15px rgba(46, 204, 113, 0.4);
}

@keyframes badgePulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* Overlay produit */
.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.overlay-content {
    text-align: center;
    color: white;
    transform: translateY(20px);
    transition: transform 0.3s ease;
}

.product-card:hover .overlay-content {
    transform: translateY(0);
}

.overlay-content i {
    font-size: 2rem;
    margin-bottom: 8px;
    display: block;
}

/* Titre produit */
.product-title {
    color: #2c3e50;
    margin-bottom: 15px;
    transition: color 0.3s ease;
    font-size: 1.1rem;
}

.product-card:hover .product-title {
    color: #2ecc71;
}

/* Container prix */
.price-container {
    position: relative;
}

.price-original {
    text-decoration: line-through;
    color: #95a5a6;
    font-size: 0.9rem;
    display: block;
}

.price-promo {
    color: #f39c12;
    font-weight: 700;
    font-size: 1.3rem;
    display: block;
    animation: priceGlow 2s ease-in-out infinite;
}

.price-normal {
    color: #2ecc71;
    font-weight: 700;
    font-size: 1.2rem;
}

.animate-price {
    animation: priceScale 0.5s ease-out;
}

@keyframes priceGlow {
    0%, 100% { 
        color: #f39c12;
        text-shadow: none;
    }
    50% { 
        color: #e67e22;
        text-shadow: 0 0 10px rgba(243, 156, 18, 0.5);
    }
}

@keyframes priceScale {
    0% { transform: scale(0.8); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

.savings-badge {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-top: 5px;
    display: inline-block;
    animation: savingsPulse 2s ease-in-out infinite;
}

@keyframes savingsPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* Indicateur stock */
.stock-indicator {
    font-size: 0.85rem;
    font-weight: 600;
}

.stock-good { color: #2ecc71; }
.stock-limited { color: #f39c12; animation: stockAlert 1.5s ease-in-out infinite; }
.stock-out { color: #e74c3c; }

@keyframes stockAlert {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* Container CTA */
.cta-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

/* Bouton ajouter au panier */
.cta-add-cart {
    position: relative;
    background: linear-gradient(135deg, #3498db, #2980b9);
    border: none;
    border-radius: 25px;
    padding: 12px 20px;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    overflow: hidden;
    transition: all 0.3s ease;
    flex: 1;
    animation: buttonBreathe 3s ease-in-out infinite;
}

.cta-add-cart:hover {
    background: linear-gradient(135deg, #2980b9, #2ecc71);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
    color: white;
}

.cta-add-cart .cart-icon {
    transition: transform 0.3s ease;
}

.cta-add-cart:hover .cart-icon {
    transform: scale(1.2) rotate(-10deg);
}

/* États du bouton */
.cta-add-cart.loading {
    background: linear-gradient(135deg, #95a5a6, #7f8c8d);
    pointer-events: none;
}

.cta-add-cart.loading .btn-text::after {
    content: "...";
    animation: loadingDots 1s infinite;
}

.cta-add-cart.success {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
}

.cta-add-cart.success .success-check {
    opacity: 1;
    transform: scale(1);
}

.cta-add-cart.error {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    animation: shake 0.5s ease-in-out;
}

@keyframes buttonBreathe {
    0%, 100% { 
        transform: scale(1);
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.2);
    }
    50% { 
        transform: scale(1.02);
        box-shadow: 0 6px 20px rgba(52, 152, 219, 0.3);
    }
}

@keyframes loadingDots {
    0%, 20% { content: "."; }
    40% { content: ".."; }
    60%, 100% { content: "..."; }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

/* Icône de succès */
.success-check {
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%) scale(0);
    opacity: 0;
    transition: all 0.3s ease;
    font-size: 1.2rem;
}

/* Bouton notification */
.cta-notify {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    border: none;
    border-radius: 25px;
    padding: 12px 20px;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    flex: 1;
    transition: all 0.3s ease;
}

.cta-notify:hover {
    background: linear-gradient(135deg, #e67e22, #f1c40f);
    color: white;
}

.cta-notify .bell-icon {
    animation: bellRing 2s ease-in-out infinite;
}

@keyframes bellRing {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(-10deg); }
    75% { transform: rotate(10deg); }
}

/* Bouton favori */
.btn-favorite {
    background: white;
    border: 2px solid #ecf0f1;
    border-radius: 50%;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #bdc3c7;
    transition: all 0.3s ease;
}

.btn-favorite:hover {
    border-color: #f39c12;
    color: #f39c12;
    transform: scale(1.1);
}

.btn-favorite.active {
    background: #f39c12;
    border-color: #f39c12;
    color: white;
    animation: heartBeat 1s ease-in-out;
}

@keyframes heartBeat {
    0%, 100% { transform: scale(1); }
    25% { transform: scale(1.1); }
    50% { transform: scale(1.2); }
    75% { transform: scale(1.1); }
}

/* Effet de brillance général */
.btn-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    transition: left 0.6s;
}

.cta-voir-plus:hover .btn-shine,
.cta-notify:hover .btn-shine {
    left: 100%;
}

/* Effet de lueur */
.btn-glow {
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    border-radius: 50px;
    background: linear-gradient(45deg, #2ecc71, #3498db, #2ecc71, #3498db);
    background-size: 400% 400%;
    opacity: 0;
    z-index: -1;
    animation: glowMove 4s ease-in-out infinite;
}

@keyframes glowMove {
    0%, 100% { 
        opacity: 0;
        background-position: 0% 50%;
    }
    25% { 
        opacity: 0.3;
        background-position: 100% 50%;
    }
    75% { 
        opacity: 0.1;
        background-position: 0% 50%;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .cta-voir-plus {
        padding: 12px 24px;
        font-size: 0.9rem;
    }
    
    .cta-add-cart,
    .cta-notify {
        padding: 10px 15px;
        font-size: 0.8rem;
    }
    
    .btn-favorite {
        width: 40px;
        height: 40px;
    }
    
    .product-badge {
        font-size: 10px;
        padding: 4px 8px;
    }
}

/* Animation d'entrée pour les cartes */
.product-card {
    animation: fadeInUp 0.6s ease-out forwards;
    opacity: 0;
    transform: translateY(30px);
}

.product-card:nth-child(1) { animation-delay: 0.1s; }
.product-card:nth-child(2) { animation-delay: 0.2s; }
.product-card:nth-child(3) { animation-delay: 0.3s; }
.product-card:nth-child(4) { animation-delay: 0.4s; }

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
</div>

