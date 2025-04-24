<div class="container py-5">
    <div class="tab-class text-center">
        <div class="row g-4 bg-grey align-items-center mb-5" data-aos="fade-up">
            <div class="col-lg-4 text-start">
                <h1 class="display-5 fw-bold gradient-text">Nos Promotions</h1>
            </div>
            <div class="col-lg-8 text-end">
                <div class="magnetic-wrap">
                    <a href="{{ route('allPromoProduit') }}" wire:navigate 
                       class="btn btn-dark rounded-pill magnetic-btn px-4 py-2 shadow-lg">
                        <span class="hover-effect"></span>
                        Voir plus <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="tab-content">
            <div id="carouselPromoProduits" 
                 class="carousel slide" 
                 data-bs-ride="carousel" 
                 data-bs-interval="5000"
                 data-bs-touch="true">
                
                <!-- Indicateurs améliorés -->
                <div class="carousel-indicators">
                    @foreach($produits->chunk(4) as $chunkIndex => $chunk)
                    <button type="button" 
                            data-bs-target="#carouselPromoProduits" 
                            data-bs-slide-to="{{ $chunkIndex }}"
                            class="indicator-progress {{ $chunkIndex === 0 ? 'active' : '' }}"
                            aria-label="Slide {{ $chunkIndex + 1 }}">
                        <div class="progress-bar"></div>
                    </button>
                    @endforeach
                </div>

                <div class="carousel-inner">
                    @foreach($produits->chunk(4) as $chunkIndex => $chunk)
                    <div class="carousel-item @if($chunkIndex === 0) active @endif">
                        <div class="row justify-content-center g-4">
                            @foreach($chunk as $produit)
                            <div class="col-md-6 col-lg-4 col-xl-3 mb-4" 
                                 data-aos="flip-up" 
                                 data-aos-delay="{{ $loop->index * 50 }}">
                                <div class="card h-100 border-0 rounded-4 shadow-sm hover-3d">
                                    <!-- Conteneur image avec effet parallaxe -->
                                    <div class="position-relative overflow-hidden image-zoom-container" 
                                         style="height: 250px;"
                                         data-tilt data-tilt-max="8">
                                        <img src="{{ $produit->getImageUrl() }}" 
                                             alt="{{ $produit->name }}" 
                                             class="img-fluid w-100 h-100 object-fit-cover zoom-image">
                                        
                                        <!-- Overlay dynamique -->
                                        <div class="card-img-overlay d-flex flex-column justify-content-between p-3">
                                            <div class="w-100 d-flex justify-content-end">
                                                <span class="badge bg-primary rounded-pill px-3 py-2 shadow glow-label">
                                                    {{ $produit->categori->titre }}
                                                </span>
                                            </div>
                                            <div class="w-100 d-grid transform-down">
                                                <a href="{{ route('produit-detail', $produit->id) }}" 
                                                   class="btn btn-light rounded-pill shadow-sm shine-hover">
                                                    Voir en détail <i class="fas fa-arrow-right ms-2"></i>
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <!-- Effet de brillance -->
                                        <div class="shine-effect"></div>
                                    </div>

                                    <!-- Corps de la carte -->
                                    <div class="card-body p-3 position-relative">
                                        <h5 class="fw-bold text-truncate hover-lift">{{ $produit->name }}</h5>
                                        
                                        <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                            <div class="price-animation">
                                                <span class="badge bg-success fs-5 px-3 py-2 bounce">
                                                    <strong>{{ $produit->prix_promo }} f cfa</strong>
                                                </span>
                                                <small class="text-muted ms-1"><strike>{{ $produit->getPrice() }}</strike></small>
                                            </div>
                                            <button class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm magnetic-button" 
                                                    wire:click="addToCart({{$produit->id}})">
                                                <span class="button-content">
                                                    <i class="fas fa-cart-plus me-2"></i> Ajouter
                                                </span>
                                                <span class="button-loader spinner-border spinner-border-sm d-none"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Contrôles customisés -->
                <button class="carousel-control-prev hover-scale-control" 
                        type="button" 
                        data-bs-target="#carouselPromoProduits" 
                        data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-3 shadow"></span>
                    <span class="visually-hidden">Précédent</span>
                </button>
                <button class="carousel-control-next hover-scale-control" 
                        type="button" 
                        data-bs-target="#carouselPromoProduits" 
                        data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-3 shadow"></span>
                    <span class="visually-hidden">Suivant</span>
                </button>
            </div>
        </div>
    </div>
    <style>
        /* Animations globales */
        .hover-3d {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), 
                        box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-3d:hover {
            transform: translateY(-8px) rotateX(2deg) rotateY(2deg);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        }

        /* Effet parallaxe */
        [data-tilt] {
            transform-style: preserve-3d;
        }

        .zoom-image {
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .image-zoom-container:hover .zoom-image {
            transform: scale(1.15);
        }

        /* Overlay dynamique */
        .card-img-overlay {
            background: linear-gradient(180deg, rgba(0,0,0,0) 30%, rgba(0,0,0,0.8) 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .card:hover .card-img-overlay {
            opacity: 1;
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

        /* Indicateurs de progression */
        .indicator-progress {
            width: 60px;
            height: 4px;
            border-radius: 2px;
            background: rgba(0,0,0,0.1);
            border: 0;
            margin: 0 4px;
        }

        .indicator-progress .progress-bar {
            height: 100%;
            width: 0;
            background: #333;
            transition: width 5s linear;
        }

        .indicator-progress.active .progress-bar {
            width: 100%;
        }

        /* Bouton magnétique */
        .magnetic-button {
            position: relative;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .magnetic-button:hover {
            transform: scale(1.05);
        }

        /* Animation prix */
        .bounce {
            animation: bounce 1s infinite alternate;
        }

        @keyframes bounce {
            from { transform: translateY(0); }
            to { transform: translateY(-5px); }
        }

        .glow-label {
            animation: glow 2s infinite alternate;
        }

        @keyframes glow {
            from { filter: drop-shadow(0 0 5px rgba(0,102,255,0.5)); }
            to { filter: drop-shadow(0 0 15px rgba(0,102,255,0.8)); }
        }
    </style>

    <script>
        // Initialisation des effets
        document.querySelectorAll('.magnetic-button').forEach(button => {
            button.addEventListener('click', function() {
                const loader = this.querySelector('.button-loader');
                const content = this.querySelector('.button-content');
                
                content.classList.add('d-none');
                loader.classList.remove('d-none');
                
                setTimeout(() => {
                    content.classList.remove('d-none');
                    loader.classList.add('d-none');
                }, 1000);
            });
        });

        // Gestion du survol des contrôles
        document.querySelectorAll('.hover-scale-control').forEach(control => {
            control.addEventListener('mouseenter', () => {
                control.style.transform = 'scale(1.2)';
            });
            
            control.addEventListener('mouseleave', () => {
                control.style.transform = 'scale(1)';
            });
        });
    </script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('produit-ajoute-panier-promo', (data) => {
                fbq('track', 'AddToCart', {
                    content_ids: [data.id],
                    content_type: 'product',
                    value: data.prix,
                    currency: 'XAF' 
                });
                console.log('Produit ajouté au panier:', data);
            });
        });
    </script>
</div>

