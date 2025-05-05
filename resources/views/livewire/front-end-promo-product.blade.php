<div class="container py-5">
    <div class="tab-class text-center">
    <div class="row g-4 bg-grey align-items-center mb-5" data-aos="fade-up">
    <div class="col-12 col-md-6 col-lg-4 text-center text-md-start mb-3 mb-md-0">
        <h1 class="display-6 fw-bold gradient-text fs-2 fs-md-1">
            En Promotions
        </h1>
    </div>
    
    <div class="col-12 col-md-6 col-lg-8 text-center text-md-end">
        <div class="magnetic-wrap d-inline-block">
            <a href="{{ route('allPromoProduit') }}" wire:navigate 
               class="btn btn-dark rounded-pill magnetic-btn px-3 px-lg-4 py-2 shadow-lg w-100 w-md-auto">
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
                        <div class="container">
                            <div class="row justify-content-center g-4">
                                @foreach($chunk as $produit)
                                <div class="col-md-6 col-lg-4 col-xl-3 mb-4" 
                                     data-aos="flip-up" 
                                     data-aos-delay="{{ $loop->index * 50 }}">
                                    <div class="card h-100 border-0 rounded-4 shadow-sm hover-3d">
                                        <!-- Conteneur image avec effet parallaxe -->
                                        <a href="{{ route('produit-detail', $produit->id) }}" 
                                            class="card-image-link d-block text-decoration-none position-relative">
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

                                                </div>
                                                
                                                <!-- Effet de brillance -->
                                                <div class="shine-effect"></div>
                                            </div>
                                        </a>

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
    /* Styles corrigés */
    .carousel-indicators {
        bottom: -50px;
    }

    .indicator-progress {
        width: 60px;
        height: 4px;
        background: rgba(0,0,0,0.1);
        border: none;
        opacity: 1 !important;
        transition: opacity 0.3s;
    }

    .indicator-progress.active .progress-bar {
        width: 100% !important;
        transition: width linear 5s !important;
    }

    .hover-3d:hover {
        transform: translateY(-8px);
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-size: 1.5rem;
    }

    /* Conserver les autres animations */
    .zoom-image { transition: transform 0.8s; }
    .card-img-overlay { transition: opacity 0.4s; }
    .shine-effect { transition: left 0.8s; }
    .magnetic-button { transition: transform 0.3s; }
</style>

<script>
    // Initialisation du carousel
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = new bootstrap.Carousel('#carouselPromoProduits', {
            interval: 5000,
            touch: true,
            wrap: true
        });

        // Réinitialiser AOS après changement de slide
        carousel._element.addEventListener('slid.bs.carousel', function() {
            AOS.refresh();
        });

        // Gestion des indicateurs de progression
        document.querySelectorAll('.indicator-progress').forEach(indicator => {
            indicator.addEventListener('click', () => {
                document.querySelectorAll('.indicator-progress .progress-bar').forEach(bar => {
                    bar.style.width = '0';
                });
                if(indicator.classList.contains('active')) {
                    indicator.querySelector('.progress-bar').style.width = '100%';
                }
            });
        });
    });

    // Initialisation AOS
    AOS.init({
        duration: 800,
        once: true,
        mirror: false
    });
</script>
</div>

