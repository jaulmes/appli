<div class="container py-0">
    <div class="text-center mb-4">
        <div class="row g-4 bg-grey align-items-center mb-0" data-aos="fade-up">
            <div class="col-lg-4 text-start">
                <h1 class="display-5 fw-bold gradient-text">
                    <a href="{{ route('all-pack') }}" style="text-decoration: none;">Nos packs</a>
                </h1>
            </div>
            <div class="col-lg-8 text-end">
                <div class="magnetic-wrap">
                    <a href="{{ route('all-pack') }}" 
                       class="btn btn-dark rounded-pill magnetic-btn px-4 py-2 shadow-lg hover-lift">
                        <span class="hover-effect"></span>
                        Voir plus <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="owl-carousel owl-theme" id="carouselPacks">
        @foreach($packs as $pack)
            <div class="item px-2">
                <div class="card h-100 border-0 rounded-4 shadow-sm">
                    <a href="{{ route('detail-pack', $pack->id) }}" class="card-image-link d-block text-decoration-none position-relative">
                        @php
                            $image1 = public_path('images/packs/'. $pack->image);
                            $image2 = public_path('storage/images/packs/'. $pack->image);
                            $url = file_exists($image1) ? asset('images/packs/'. $pack->image)
                                                       : asset('storage/images/packs/' . $pack->image);
                        @endphp

                        <img src="{{ $url }}" class="card-img-top img-fluid" alt="{{ $pack->name }}" style="object-fit: cover; height: 250px;">
                    </a>

                    <div class="card-body p-3 text-center">
                        <h5 class="fw-bold">{{ $pack->titre }}</h5>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="badge bg-success fs-6">{{ $pack->prix }}</span>
                            <button wire:click="addProductToCart({{ $pack->id }})" class="btn btn-sm btn-primary rounded-pill px-3">
                                <i class="fas fa-cart-plus me-1"></i> Ajouter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <script>
        $(document).ready(function(){
            $('#carouselPacks').owlCarousel({
                loop: true,
                margin: 15,
                nav: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 1000,
                autoplayHoverPause: true,
                responsive:{
                    0:{ items:1 },
                    576:{ items:2 },
                    768:{ items:3 },
                    992:{ items:4 }
                }
            });
        });
    </script>

</div>
