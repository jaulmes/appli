<div class="container py-0">
    <div class="text-center mb-4">
        <div class="row g-4 align-items-center mb-0" data-aos="fade-up">
            <div class="col-lg-4 text-start">
                <h1 class="display-5 fw-bold gradient-text">
                    <i class="fas fa-th-large me-2"></i> Nos Catégories
                </h1>
            </div>
            <div class="col-lg-8 text-end">
                <div class="magnetic-wrap">
                    <a href="{{ route('all-categorie') }}" class="btn cta-voir-plus magnetic-btn hover-lift">
                        <span class="btn-content">
                            <span class="btn-text">Voir toutes les catégories</span>
                            <i class="fas fa-arrow-right ms-2 arrow-icon"></i>
                        </span>
                        <div class="btn-shine"></div>
                        <div class="btn-glow"></div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($categoris->isEmpty())
        <div class="alert alert-warning text-center">
            Aucune catégorie disponible pour le moment.
        </div>
    @else
        <div wire:ignore>
            <div class="owl-carousel owl-theme" id="carouselCategories">
                @foreach($categoris as $categori)
                    <div class="item px-2">
                        <div class="card product-card h-100 border-0 rounded-4 shadow-sm hover-3d">
                            <a href="{{ route('categorie-detail', $categori->id) }}" class="card-image-link d-block text-decoration-none position-relative">
                                @php
                                    $image1 = public_path('images/produits/categories/'. $categori->image_categorie);
                                    $url = file_exists($image1) ? asset('images/produits/categories/'. $categori->image_categorie)
                                                                : asset('storage/images/produits/categories/' . $categori->image_categorie);
                                @endphp
                                <img src="{{ $url }}" class="card-img-top img-fluid product-image zoom-image" alt="{{ $categori->titre }}" style="object-fit: cover; height: 200px; border-radius: 50%;">

                                <!-- Badge catégorie -->
                                <div class="product-badge pack-badge">
                                    <i class="fas fa-tag"></i> CATÉGORIE
                                </div>

                                <!-- Overlay -->
                                <div class="product-overlay">
                                    <div class="overlay-content">
                                        <i class="fas fa-eye"></i>
                                        <span>Voir les produits</span>
                                    </div>
                                </div>
                            </a>

                            <div class="card-body p-3 text-center d-flex flex-column">
                                <h5 class="product-title fw-bold text-truncate gradient-text">{{ $categori->titre }}</h5>
                                <div class="mt-auto cta-container">
                                    <a href="{{ route('categorie-detail', $categori->id) }}" 
                                       class="btn cta-add-cart pulse-button">
                                        <span class="btn-content">
                                            <i class="fas fa-box"></i>
                                            <span class="btn-text">Voir les produits</span>
                                        </span>
                                        <div class="btn-ripple"></div>
                                        <div class="success-check"><i class="fas fa-check"></i></div>
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
    let categoriesCarouselInitialized = false;

    function initializeCategoriesCarousel() {
        if (!categoriesCarouselInitialized) {
            $('#carouselCategories').owlCarousel({
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
            categoriesCarouselInitialized = true;
        }
    }

    document.addEventListener('DOMContentLoaded', function(){
        AOS.init({ duration:800, once:true });
        initializeCategoriesCarousel();
    });

    document.addEventListener('livewire:load', initializeCategoriesCarousel);
    document.addEventListener('livewire:navigated', () => setTimeout(initializeCategoriesCarousel, 100));
    </script>
</div>
