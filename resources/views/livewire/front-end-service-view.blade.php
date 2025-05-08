<div>
  <div class="container-fluid py-0 position-relative bg-light overflow-hidden">

    {{-- Balises décoratives --}}
    <div class="bg-shapes-top position-absolute start-0 top-0"></div>
    <div class="bg-shapes-bottom position-absolute end-0 bottom-0"></div>

    {{-- En-tête section --}}
    <div class="text-center mb-5" role="banner">
      <h3 class="text-warning fw-bold mb-2" style="letter-spacing:2px;">Services</h3>
      <h2 class="fw-bold display-6 text-uppercase" style="color:#004075;" id="services-heading">
        Découvrez nos services
      </h2>
    </div>

    {{-- Fallback pour les bots sans JS --}}
    <noscript>
      @foreach($services as $service)
        <div>
          <a href="{{ route('detail-service', $service->id) }}">
            {{ $service->name }}
          </a>
        </div>
      @endforeach
    </noscript>

    {{-- JSON-LD ItemList --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "ItemList",
      "itemListElement": [
        @foreach($services as $index => $s)
        {
          "@type": "ListItem",
          "position": {{ $index + 1 }},
          "url": "{{ route('detail-service', $s->id) }}",
          "name": "{{ $s->name }}"
        }@if(!$loop->last),@endif
        @endforeach
      ]
    }
    </script>

    {{-- Grille de cartes --}}
    <div class="row g-4 justify-content-center" aria-labelledby="services-heading">
      @foreach($services as $service)
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">

            {{-- Image --}}
            <figure class="mb-0">
              <img
                src="{{ asset('storage/images/services/'.$service->image) }}"
                alt="Photo du service {{ $service->name }}"
                loading="lazy"
                class="d-block w-100 object-fit-cover"
                style="height:200px;"
              >
            </figure>

            {{-- Contenu --}}
            <div class="card-body d-flex flex-column">

              <h3 class="h5 card-title fw-bold text-truncate" title="{{ $service->name }}">
                {{ $service->name }}
              </h3>

              <p class="card-text text-muted small">
                {{ Str::limit($service->description, 80) }}
              </p>

              {{-- Bouton --}}
              <div class="mt-auto text-center">
                <a
                  href="{{ route('detail-service', $service->id) }}"
                  class="btn btn-primary rounded-pill px-4"
                  aria-label="En savoir plus sur {{ $service->name }}"
                >
                  En savoir plus
                </a>
              </div>

            </div>
          </div>
        </div>
      @endforeach
    </div>

    {{-- Bouton global --}}
    <div class="text-center mt-5">
      <a
        href="#"
        class="btn btn-warning text-dark rounded-pill px-4 py-2 shadow"
        role="button"
      >
        Découvrir plus
      </a>
    </div>

  </div>

  {{-- Styles personnalisés --}}
  <style>
    .overflow-hidden { overflow-x: hidden; }
    .object-fit-cover { object-fit: cover; }
    .bg-shapes-top::before,
    .bg-shapes-bottom::before {
      content: "";
      position: absolute;
      width: 200px; height: 200px;
      background: radial-gradient(circle, #ffa500 0%, #ff7f00 100%);
      opacity: .3; z-index: -1;
      border-radius: 50%;
    }
    .bg-shapes-top::before { top: -50px; left: -50px; }
    .bg-shapes-bottom::before { bottom: -50px; right: -50px; }

    .btn-primary {
      background: linear-gradient(135deg,#007bff,#0056b3);
      border: none;
    }
    .btn-primary:hover {
      background: linear-gradient(135deg,#0056b3,#003f7f);
    }
    .btn-warning {
      background: linear-gradient(135deg,#ffaf00,#ff7f00);
      border: none;
    }
    .btn-warning:hover {
      background: linear-gradient(135deg,#ff7f00,#ff5a00);
    }
  </style>

</div>
