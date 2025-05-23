<section aria-labelledby="promo-titre" style="font-size: small;">
  {{-- Section principale --}}
  {{-- En-tête section --}}
  <h2 id="promo-titre" class="display-6 fw-bold gradient-text fs-2 fs-md-1 text-center mb-4">
    <a href="{{ route('all-pack') }}" class="text-decoration-none text-dark">
      <i class="fas fa-tags me-2"></i>
      Nos Packs
    </a>
  </h2>

  {{-- Fallback pour les bots sans JS --}}
  <noscript>
    @foreach($packs as $pack)
      <div>
        <a href="{{ route('detail-pack', $pack->id) }}">
          {{ $pack->name }} – {{ $pack->prix_promo }} FCFA
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
      @foreach($packs as $index => $p)
      {
        "@type":"ListItem",
        "position":{{ $index + 1 }},
        "url":"{{ route('detail-pack', $p->id) }}",
        "name":"{{ $p->name }}"
      }@if(!$loop->last),@endif
      @endforeach
    ]
  }
  </script>

  {{-- Carrousel Bootstrap --}}
  <div id="carouselPromopacks"
        class="carousel slide"
        data-bs-ride="carousel"
        data-bs-interval="1500"
        data-bs-touch="true"
        aria-labelledby="promo-titre">

    {{-- Indicateurs --}}
    <div class="carousel-indicators">
      @foreach($packs->chunk(4) as $chunkIndex => $chunk)
        <button type="button"
                data-bs-target="#carouselPromopacks"
                data-bs-slide-to="{{ $chunkIndex }}"
                class="{{ $chunkIndex === 0 ? 'active' : '' }}"
                aria-label="Slide {{ $chunkIndex + 1 }}">
          <span class="visually-hidden">Voir slide {{ $chunkIndex + 1 }}</span>
        </button>
      @endforeach
    </div>

    {{-- Slides --}}
    <div class="carousel-inner">
      @foreach($packs->chunk(4) as $chunkIndex => $chunk)
        <div class="carousel-item @if($chunkIndex === 0) active @endif">
          <div class="row justify-content-center g-4">
            @foreach($chunk as $pack)
              <div class="col-md-6 col-lg-4 col-xl-3" data-aos="flip-up" data-aos-delay="{{ $loop->index * 50 }}">
                <div class="card h-100 border-0 rounded-4 shadow-sm hover-3d">

                  {{-- Lien pack --}}
                  <a href="{{ route('detail-pack', $pack->id) }}"
                        class="d-block  position-relative mb-3"
                        aria-label="Voir détail {{ $pack->titre }}"
                        style="text-decoration: none; ">
                        <div class=" overflow-hidden image-zoom-container" style="height:250px;" data-tilt data-tilt-max="8">
                            <img src="{{ asset('storage/images/packs/'.$pack->image) }}"
                                alt="Photo de {{ $pack->titre }}"
                                class="img-fluid w-100 h-100 object-fit-cover zoom-image"
                                style="height: 50px; padding-top: -3em;"/>

                            {{-- titre --}}
                            <div class="card-img-overlay d-flex flex-column justify-content-between p-3">
                                <div class="w-100 d-flex justify-content-end">
                                    <span class="badge bg-primary rounded-pill px-3 py-2 shadow glow-label">
                                        {{ $pack->titre }}
                                    </span>
                                </div>

                            </div>

                        </div>
                  </a>

                  {{-- Corps de la carte --}}
                  <div class="card-body p-3">
                    
                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                      <div>
                        <span class="badge bg-success px-3 py-2 ">
                          {{ number_format($pack->prix, 0, '.', ' ') }} FCFA
                        </span><br>
                        
                      </div>
                      <button class="btn btn-sm btn-primary rounded-pill px-3"
                              wire:click="addPackToCart({{ $pack->id }})"
                              aria-label="Ajouter {{ $pack->titre }} au panier">
                        <i class="fas fa-cart-plus me-1"></i>Ajouter
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

    {{-- Contrôles --}}
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselPromopacks" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Précédent</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselPromopacks" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Suivant</span>
    </button>
  </div>

  {{-- Lien vers toutes les promos --}}
  <div class="text-center mt-4">
    <a href="{{ route('all-pack') }}" class="btn btn-dark rounded-pill px-4">
      Voir tout nos Pack<i class="fas fa-arrow-right ms-2"></i>
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
      let carouselEl = document.getElementById('carouselPromopacks');
      carouselEl.addEventListener('slid.bs.carousel', () => AOS.refresh());
    });
  </script>
</section>

