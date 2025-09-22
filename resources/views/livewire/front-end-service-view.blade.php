<div class="container py-0">
    <div class="text-center mb-4">
        <div class="row g-4 bg-grey align-items-center mb-0" data-aos="fade-up">
            <div class="col-lg-4 text-start">
                <h1 class="display-5 fw-bold gradient-text">
                    <a href="{{ route('nos-services') }}" style="text-decoration: none;">
                        <i class="fas fa-cogs me-2"></i> Nos Services
                    </a>
                </h1>
            </div>
            <div class="col-lg-8 text-end">
                <div class="magnetic-wrap">
                    <!-- Bouton CTA -->
                    <a href="{{ route('nos-services') }}" 
                       class="btn cta-voir-plus magnetic-btn hover-lift">
                        <span class="btn-content">
                            <span class="btn-text">Voir tous les services</span>
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
        @foreach($services as $service)
            <div>
                <a href="{{ route('detail-service', $service->id) }}">
                    {{ $service->name }}
                </a>
            </div>
        @endforeach
    </noscript>

    {{-- Carrousel Owl --}}
    <div wire:ignore>
        <div class="owl-carousel owl-theme" id="carouselServices">
            @foreach($services as $service)
                <div class="item px-2">
                    <div class="card product-card h-100 border-0 rounded-4 shadow-sm">
                        <a href="{{ route('detail-service', $service->id) }}" 
                           class="card-image-link d-block text-decoration-none position-relative">
                            @php
                                $image1 = public_path('images/services/'. $service->image);
                                $url = file_exists($image1)
                                        ? asset('images/services/'. $service->image)
                                        : asset('storage/images/services/' . $service->image);
                            @endphp

                            <img src="{{ $url }}" class="card-img-top img-fluid product-image" alt="{{ $service->name }}" style="object-fit: cover; height: 250px;">

                            <!-- Badge service -->
                            <div class="product-badge pack-badge">
                                <i class="fas fa-tools"></i> SERVICE
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
                            <h5 class="product-title fw-bold">{{ $service->name }}</h5>

                            <!-- Description -->
                            <p class="text-muted small mb-3">{{ Str::limit($service->description, 80) }}</p>

                            <!-- CTA -->
                            <div class="cta-container">
                                <a href="{{ route('detail-service', $service->id) }}" 
                                   class="btn cta-add-cart pulse-button">
                                    <span class="btn-content">
                                        <i class="fas fa-info-circle"></i>
                                        <span class="btn-text">En savoir plus</span>
                                    </span>
                                    <div class="btn-ripple"></div>
                                    <div class="success-check">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
    let servicesCarouselInitialized = false;

    function initializeServicesCarousel() {
        if (!servicesCarouselInitialized) {
            $('#carouselServices').owlCarousel({
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
            servicesCarouselInitialized = true;
        }
    }

    document.addEventListener('DOMContentLoaded', function(){
        AOS.init({ duration:800, once:true });
        initializeServicesCarousel();
    });

    document.addEventListener('livewire:load', initializeServicesCarousel);
    document.addEventListener('livewire:navigated', () => setTimeout(initializeServicesCarousel, 100));
    </script>
</div>
