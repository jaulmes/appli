@extends('frontend.layout.index')

<!-- Meta Open Graph & product pour Facebook -->
@section('head')
    @php
        // Logique pour récupérer toutes les images
        $allImages = collect();
        
        // Nouvelle logique : images multiples
        if($produit->images && $produit->images->count() > 0) {
            foreach($produit->images as $img) {
                $allImages->push([
                    'url' => asset('images/produits/' . $img->path),
                    'is_gif' => $img->is_gif ?? (strtolower(pathinfo($img->path, PATHINFO_EXTENSION)) === 'gif'),
                    'path' => $img->path
                ]);
            }
        }
        
        // Ancienne logique : image unique
        if($produit->image_produit) {
            $oldPath1 = public_path('storage/images/produits/' . $produit->image_produit);
            $oldPath2 = public_path('images/produits/' . $produit->image_produit);
            $oldImageUrl = file_exists($oldPath1)
                ? asset('storage/images/produits/' . $produit->image_produit)
                : asset('images/produits/' . $produit->image_produit);
            
            $allImages->push([
                'url' => $oldImageUrl,
                'is_gif' => strtolower(pathinfo($produit->image_produit, PATHINFO_EXTENSION)) === 'gif',
                'path' => $produit->image_produit
            ]);
        }
        
        // Trier : GIF en premier
        $allImages = $allImages->sortByDesc('is_gif')->values();
        
        // Image principale (première image, priorité au GIF)
        $mainImage = $allImages->first()['url'] ?? asset('images/default-product.png');
    @endphp
    
    <!-- Balises Open Graph obligatoires -->
    <meta property="og:type" content="product" />
    <meta property="og:title" content="{{ $produit->name }}" />
    <meta property="og:description" content="{{ Str::limit($produit->description, 100) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ $mainImage }}" />

    <!-- Balises produit spécifiques (Meta Commerce) -->
    <meta property="product:brand" content="{{ $produit->fabricant }}" />
    <meta property="product:availability" content="{{ 'in stock' }}" />
    <meta property="product:condition" content="new" />
    <meta property="product:price:amount" content="{{ $produit->status_promo ? $produit->prix_promo : $produit->price }}" />
    <meta property="product:price:currency" content="XAF" />
    <meta property="product:retailer_item_id" content="{{ $produit->id }}" />
    <meta property="product:item_group_id" content="{{ $produit->categori->id }}" />
    <meta property="product:category" content="{{ $produit->categori->titre }}" />
    
    <script>
        fbq('track', 'ViewContent', {
            content_ids: ['{{ $produit->id }}'],
            content_type: 'product',
        });
    </script>                     
@endsection

@section('content')
<div class="container py-5" style="margin-top: 10em;">
    <form action="{{ route('add-to-cart', $produit->id) }}" method="post">
        @csrf
        <div class="row">
            <!-- Galerie d'images -->
            <div class="col-md-6">
                <!-- Image principale -->
                <div class="main-image-container position-relative overflow-hidden rounded-4 shadow-lg mb-3">
                    <img id="mainImage" 
                         src="{{ $mainImage }}"
                         class="card-img-top img-fluid w-100"
                         alt="{{ $produit->name }}"
                         style="object-fit: cover; height: 500px; transition: transform 0.5s ease;">
                    
                    @if($allImages->first()['is_gif'] ?? false)
                        <span class="position-absolute top-0 start-0 m-3 badge bg-warning fs-6 animate-badge">
                            <i class="fas fa-film me-1"></i>GIF ANIMÉ
                        </span>
                    @endif
                    
                    <!-- Boutons de navigation -->
                    @if($allImages->count() > 1)
                        <button type="button" class="btn btn-nav btn-nav-prev" onclick="changeImage(-1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-nav btn-nav-next" onclick="changeImage(1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    @endif
                    
                    <!-- Compteur d'images -->
                    @if($allImages->count() > 1)
                        <div class="image-counter position-absolute bottom-0 end-0 m-3 badge bg-dark bg-opacity-75">
                            <span id="currentImageIndex">1</span> / {{ $allImages->count() }}
                        </div>
                    @endif
                </div>

                <!-- Miniatures -->
                @if($allImages->count() > 1)
                    <div class="thumbnails-container d-flex gap-2 overflow-auto pb-2" style="scroll-behavior: smooth;">
                        @foreach($allImages as $index => $image)
                            <div class="thumbnail-wrapper {{ $index === 0 ? 'active' : '' }}" 
                                 onclick="selectImage({{ $index }})"
                                 data-index="{{ $index }}">
                                <img src="{{ $image['url'] }}" 
                                     class="thumbnail-image rounded-3 shadow-sm"
                                     alt="Image {{ $index + 1 }}"
                                     style="width: 80px; height: 80px; object-fit: cover; cursor: pointer; transition: all 0.3s ease; border: 3px solid transparent;">
                                
                                @if($image['is_gif'])
                                    <span class="badge badge-mini bg-warning position-absolute top-0 end-0 m-1">
                                        <i class="fas fa-film"></i>
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Informations produit -->
            <div class="col-md-6">
                <h1 class="fw-bold mb-3">{{ $produit->name }}</h1>
                
                <!-- Prix dynamique avec promotion -->
                <div class="row align-items-center mb-4">
                    <div class="col-auto">
                        @if($produit->status_promo)
                            <del class="text-muted me-2 fs-5">{{ number_format($produit->price, 0, ',', ' ') }} FCFA</del>
                            <span class="badge bg-gradient-success fs-3 px-4 py-2">
                                {{ number_format($produit->prix_promo, 0, ',', ' ') }} FCFA
                            </span>
                        @else
                            <span class="badge bg-gradient-success fs-3 px-4 py-2">
                                {{ number_format($produit->price, 0, ',', ' ') }} FCFA
                            </span>
                        @endif
                    </div>
                    
                    <!-- Badge stock -->
                    <div class="col-auto">
                        @if($produit->stock > 5)
                            <span class="badge bg-success px-3 py-2">
                                <i class="fas fa-check-circle me-1"></i>En stock ({{ $produit->stock }})
                            </span>
                        @elseif($produit->stock > 0)
                            <span class="badge bg-warning px-3 py-2">
                                <i class="fas fa-exclamation-triangle me-1"></i>Stock limité ({{ $produit->stock }})
                            </span>
                        @else
                            <span class="badge bg-danger px-3 py-2">
                                <i class="fas fa-times-circle me-1"></i>Rupture de stock
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Description formatée -->
                <div class="mb-4 product-description p-4 bg-light rounded-3">
                    <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>Description</h5>
                    <div class="description-content">
                        {!! str_replace(';', '<br>', e($produit->description)) !!}
                    </div>
                </div>

                <!-- Actions d'achat -->
                <div class="d-flex gap-3 mb-4">
                    @if($produit->stock > 0)
                        <button type="submit" class="btn cta-button cta-primary animated-cta large-cta flex-grow-1">
                            <span class="btn-content">
                                <i class="fas fa-cart-plus me-2"></i>
                                <span class="btn-text">Ajouter au panier</span>
                            </span>
                            <div class="btn-shine"></div>
                            <div class="success-ripple"></div>
                        </button>
                    @else
                        <button type="submit" class="btn cta-button cta-reserve animated-cta large-cta flex-grow-1">
                            <span class="btn-content">
                                <i class="fas fa-bolt me-2 pulse-icon"></i>
                                <span class="btn-text">Réserver maintenant</span>
                            </span>
                            <div class="btn-shine"></div>
                            <div class="urgent-glow"></div>
                        </button>
                    @endif
                </div>

                <!-- Métadonnées -->
                <div class="product-meta p-3 bg-light rounded-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-layer-group me-2 text-primary"></i>
                        <strong class="me-2">Catégorie:</strong>
                        <span>{{ $produit->categori->titre }}</span>
                    </div>
                    @if($produit->fabricant)
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-industry me-2 text-primary"></i>
                            <strong class="me-2">Fabricant:</strong>
                            <span>{{ $produit->fabricant }}</span>
                        </div>
                    @endif
                    <div class="d-flex align-items-center">
                        <i class="fas fa-barcode me-2 text-primary"></i>
                        <strong class="me-2">Référence:</strong>
                        <span>#{{ $produit->id }}</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    /* === GALERIE D'IMAGES === */
    .main-image-container {
        position: relative;
        background: #f8f9fa;
    }

    .main-image-container img {
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .main-image-container:hover img {
        transform: scale(1.05);
    }

    /* Badge GIF animé */
    .animate-badge {
        animation: badgePulse 2s ease-in-out infinite;
    }

    @keyframes badgePulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    /* Boutons de navigation */
    .btn-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.6);
        border: none;
        color: white;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        backdrop-filter: blur(5px);
    }

    .btn-nav:hover {
        background: rgba(0, 0, 0, 0.8);
        transform: translateY(-50%) scale(1.1);
    }

    .btn-nav-prev {
        left: 15px;
    }

    .btn-nav-next {
        right: 15px;
    }

    /* Compteur d'images */
    .image-counter {
        font-size: 14px;
        padding: 8px 12px;
        border-radius: 20px;
    }

    /* === MINIATURES === */
    .thumbnails-container {
        position: relative;
        padding: 10px 0;
    }

    .thumbnails-container::-webkit-scrollbar {
        height: 8px;
    }

    .thumbnails-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .thumbnails-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .thumbnails-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .thumbnail-wrapper {
        position: relative;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .thumbnail-wrapper:hover .thumbnail-image {
        transform: scale(1.1);
        border-color: #667eea !important;
    }

    .thumbnail-wrapper.active .thumbnail-image {
        border-color: #667eea !important;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
    }

    .thumbnail-image {
        transition: all 0.3s ease;
    }

    .badge-mini {
        font-size: 10px;
        padding: 2px 4px;
    }

    /* === DESCRIPTION === */
    .product-description {
        border-left: 4px solid #667eea;
    }

    .description-content {
        line-height: 1.8;
        color: #555;
    }

    /* === BADGES GRADIENT === */
    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        animation: priceGlow 2s ease-in-out infinite;
    }

    @keyframes priceGlow {
        0%, 100% { box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); }
        50% { box-shadow: 0 6px 25px rgba(40, 167, 69, 0.5); }
    }

    /* === MÉTADONNÉES === */
    .product-meta {
        border-left: 4px solid #28a745;
    }

    /* === BOUTONS CTA === */
    .cta-button {
        position: relative;
        overflow: hidden;
        border: none;
        border-radius: 50px;
        padding: 12px 28px;
        font-weight: 600;
        font-size: 16px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        min-width: 200px;
        z-index: 1;
    }

    .large-cta {
        padding: 18px 40px;
        font-size: 18px;
        min-width: 100%;
    }

    .btn-content {
        position: relative;
        z-index: 3;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
    }

    .cta-primary {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        animation: breathe 3s ease-in-out infinite;
    }

    .cta-primary:hover {
        background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%);
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 15px 35px rgba(40, 167, 69, 0.4);
        color: white;
    }

    .cta-reserve {
        background: linear-gradient(135deg, #fd7e14 0%, #dc3545 100%);
        color: white;
        animation: urgentPulse 2s ease-in-out infinite;
    }

    .cta-reserve:hover {
        background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 15px 35px rgba(220, 53, 69, 0.4);
        color: white;
    }

    @keyframes breathe {
        0%, 100% { transform: scale(1); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
        50% { transform: scale(1.02); box-shadow: 0 12px 35px rgba(40, 167, 69, 0.25); }
    }

    @keyframes urgentPulse {
        0%, 100% { transform: scale(1); box-shadow: 0 8px 25px rgba(220, 53, 69, 0.2); }
        25% { transform: scale(1.03); box-shadow: 0 12px 35px rgba(220, 53, 69, 0.35); }
        75% { transform: scale(1.01); box-shadow: 0 10px 30px rgba(220, 53, 69, 0.3); }
    }

    .btn-shine {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: left 0.6s;
        z-index: 2;
    }

    .cta-button:hover .btn-shine {
        left: 100%;
    }

    .cta-primary:hover .fa-cart-plus {
        animation: cartBounce 0.6s ease-in-out;
    }

    @keyframes cartBounce {
        0%, 100% { transform: scale(1) rotate(0deg); }
        25% { transform: scale(1.2) rotate(-5deg); }
        75% { transform: scale(1.1) rotate(5deg); }
    }

    .pulse-icon {
        animation: iconPulse 1.5s ease-in-out infinite;
    }

    @keyframes iconPulse {
        0%, 100% { transform: scale(1); color: rgba(255,255,255,1); }
        50% { transform: scale(1.2); color: rgba(255,255,255,0.8); filter: drop-shadow(0 0 8px rgba(255,255,255,0.8)); }
    }

    .success-ripple {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.6);
        transform: translate(-50%, -50%);
        z-index: 1;
    }

    .cta-primary:active .success-ripple {
        animation: successRipple 0.8s ease-out;
    }

    @keyframes successRipple {
        0% { width: 0; height: 0; opacity: 1; }
        100% { width: 300px; height: 300px; opacity: 0; }
    }

    .urgent-glow {
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        border-radius: 50px;
        background: linear-gradient(45deg, #ff6b6b, #ee5a24, #ff6b6b, #ee5a24);
        background-size: 400% 400%;
        opacity: 0;
        z-index: -1;
        animation: urgentGlow 3s ease-in-out infinite;
    }

    @keyframes urgentGlow {
        0%, 100% { opacity: 0; background-position: 0% 50%; }
        25% { opacity: 0.3; background-position: 100% 50%; }
        75% { opacity: 0.1; background-position: 0% 50%; }
    }

    .animated-cta {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .container {
            margin-top: 5em !important;
        }
        
        .main-image-container img {
            height: 300px !important;
        }

        .thumbnail-image {
            width: 60px !important;
            height: 60px !important;
        }

        .btn-nav {
            width: 35px;
            height: 35px;
            font-size: 12px;
        }

        .large-cta {
            padding: 14px 25px;
            font-size: 16px;
        }
    }
</style>

<script>
    // Données des images
    const images = @json($allImages);
    let currentIndex = 0;

    // Changer d'image (navigation)
    function changeImage(direction) {
        currentIndex += direction;
        
        if (currentIndex < 0) {
            currentIndex = images.length - 1;
        } else if (currentIndex >= images.length) {
            currentIndex = 0;
        }
        
        updateMainImage();
    }

    // Sélectionner une image via miniature
    function selectImage(index) {
        currentIndex = index;
        updateMainImage();
    }

    // Mettre à jour l'image principale
    function updateMainImage() {
        const mainImage = document.getElementById('mainImage');
        const currentImageIndexEl = document.getElementById('currentImageIndex');
        const badge = document.querySelector('.animate-badge');
        
        // Changement d'image avec animation
        mainImage.style.opacity = '0';
        mainImage.style.transform = 'scale(0.95)';
        
        setTimeout(() => {
            mainImage.src = images[currentIndex].url;
            mainImage.style.opacity = '1';
            mainImage.style.transform = 'scale(1)';
            
            // Mettre à jour le compteur
            if (currentImageIndexEl) {
                currentImageIndexEl.textContent = currentIndex + 1;
            }
            
            // Mettre à jour le badge GIF
            if (badge) {
                badge.style.display = images[currentIndex].is_gif ? 'inline-block' : 'none';
            }
            
            // Mettre à jour les miniatures actives
            document.querySelectorAll('.thumbnail-wrapper').forEach((thumb, index) => {
                if (index === currentIndex) {
                    thumb.classList.add('active');
                } else {
                    thumb.classList.remove('active');
                }
            });
            
            // Scroll vers la miniature active
            const activeThumbnail = document.querySelector(`.thumbnail-wrapper[data-index="${currentIndex}"]`);
            if (activeThumbnail) {
                activeThumbnail.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
        }, 200);
    }

    // Navigation au clavier
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            changeImage(-1);
        } else if (e.key === 'ArrowRight') {
            changeImage(1);
        }
    });

    // Zoom sur l'image au clic
    document.getElementById('mainImage').addEventListener('click', function() {
        this.style.transform = this.style.transform === 'scale(1.5)' ? 'scale(1)' : 'scale(1.5)';
    });
</script>
@endsection