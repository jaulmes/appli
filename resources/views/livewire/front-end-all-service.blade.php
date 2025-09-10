<div class="row justify-content-center">
    @foreach($services as $service)
      <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card border-0 shadow-sm h-100  rounded-4 overflow-hidden">

            {{-- Image --}}
            <figure class="mb-0">
              @php
                  $image1 = public_path('images/services/'. $service->image);
                  $image2 = public_path('storage/images/services/'. $service->image);
                  $url = file_exists($image1)? asset('images/services/'. $service->image)
                                              : asset('storage/images/services/' . $service->image);
              @endphp
              <a href="{{ route('detail-service', $service->id) }}">
                <img src="{{$url }}"
                  alt="{{ $service->name }}"
                  loading="lazy"
                  class="d-block w-100 object-fit-cover"
                  style="height:200px;">
              </a>
              
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