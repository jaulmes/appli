<section aria-labelledby="promo-titre" style="font-size: small;">
  {{-- Section principale --}}
  {{-- En-tête section --}}
  <h2 id="promo-titre" class="display-6 fw-bold gradient-text fs-2 fs-md-1 text-center mb-4">
    <a href="{{ route('allPromoProduit') }}" class="text-decoration-none text-dark">
      <i class="fas fa-tags me-2"></i>
      En Promotion
    </a>
  </h2>

  {{-- Fallback pour les bots sans JS --}}
  <noscript>
    @foreach($produits as $produit)
      <div>
        <a href="{{ route('produit-detail', $produit->id) }}">
          {{ $produit->name }} – {{ $produit->prix_promo }} FCFA
        </a>
      </div>
    @endforeach
  </noscript>

  {{-- JSON-LD ItemList pour SEO --}}
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

  {{-- Carrousel Bootstrap --}}
  <div id="carouselPromoProduits"
        class="carousel slide"
        data-bs-ride="carousel"
        data-bs-interval="1500"
        data-bs-touch="true"
        aria-labelledby="promo-titre">

    {{-- Indicateurs --}}
    <div class="carousel-indicators">
      @foreach($produits->chunk(4) as $chunkIndex => $chunk)
        <button type="button"
                data-bs-target="#carouselPromoProduits"
                data-bs-slide-to="{{ $chunkIndex }}"
                class="{{ $chunkIndex === 0 ? 'active' : '' }}"
                aria-label="Slide {{ $chunkIndex + 1 }}">
          <span class="visually-hidden">Voir slide {{ $chunkIndex + 1 }}</span>
        </button>
      @endforeach
    </div>

    {{-- Slides --}}
    <div class="owl-carousel owl-theme" id="carouselProduitsPromo">
        @foreach($produits as $produit)
            <div class="item px-2">
                <div class="card h-100 border-0 rounded-4 shadow-sm">
                    <a href="{{ route('produit-detail', $produit->id) }}" class="card-image-link d-block text-decoration-none position-relative">
                        @php
                            $image1 = public_path('images/produits/'. $produit->image_produit);
                            $image2 = public_path('storage/images/produits/'. $produit->image_produit);
                            $url = file_exists($image1) ? asset('images/produits/'. $produit->image_produit)
                                                       : asset('storage/images/produits/' . $produit->image_produit);
                        @endphp

                        <img src="{{ $url }}" class="card-img-top img-fluid" alt="{{ $produit->name }}" style="object-fit: cover; height: 250px;">
                    </a>

                    <div class="card-body p-3 text-center">
                        <h5 class="fw-bold">{{ $produit->name }}</h5>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div>
                              <span class="badge bg-success  px-3 py-2">
                                {{ $produit->prix_promo }} FCFA
                              </span><br>
                              <small class="text-muted ms-1">
                                <del>{{ $produit->getPrice() }} FCFA</del>
                              </small>
                            </div>
                            <button wire:click="addProductToCart({{ $produit->id }})" class="btn btn-sm btn-primary rounded-pill px-3">
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
            $('#carouselProduitsPromo').owlCarousel({
                loop: true,
                margin: 15,
                nav: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 3000,
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

  {{-- Lien vers toutes les promos --}}
  <div class="text-center mt-4">
    <a href="{{ route('allPromoProduit') }}" class="btn btn-dark rounded-pill px-4">
      Voir toutes les promotions <i class="fas fa-arrow-right ms-2"></i>
    </a>
  </div>
  {{-- Styles spécifiques (votre fichier CSS principal peut aussi les contenir) --}}
  <style>
    .hover-3d:hover { transform: translateY(-8px); }
    .zoom-image { transition: transform .8s; }

  </style>

  {{-- Scripts d’initialisation --}}
  <script>
    document.addEventListener('DOMContentLoaded', function(){
      // Initialisation AOS
      AOS.init({ 
        duration:800, 
        once:true 
      });
      // Collapse les indicateurs et répète l’animation au slide
      let carouselEl = document.getElementById('carouselPromoProduits');
      carouselEl.addEventListener('slid.bs.carousel', () => AOS.refresh());
    });
  </script>
</section>

