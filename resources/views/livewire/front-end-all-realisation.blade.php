<div class="row g-4 justify-content-center">
    @foreach($realisations as $realisation)
        @php
            $images = array_filter([
                $realisation->img1, 
                $realisation->img2, 
                $realisation->img3, 
                $realisation->img4, 
                $realisation->img5
            ]);
        @endphp
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                {{-- Image de la réalisation --}}
                <div id="carouselRealisation{{ $realisation->id }}" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($images as $key => $image)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                @php
                                    $image1 = public_path('images/Realisations/'. $realisation->img1);
                                    $image2 = public_path('storage/images/Realisations/'. $realisation->img1);
                                    $url = file_exists($image1)? asset('images/Realisations/'. $image)
                                                                : asset('storage/images/Realisations/' . $image);
                                @endphp
                                <img 
                                    src="{{ $url }}" 
                                    alt="Image de la réalisation"
                                    class="d-block w-100 object-fit-cover"
                                    style="height: 200px;"
                                >
                            </div>
                        @endforeach
                    </div>
                    @if(count($images) > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselRealisation{{ $realisation->id }}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Précédent</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselRealisation{{ $realisation->id }}" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Suivant</span>
                    </button>
                    @endif
                </div>
                {{-- Corps de la carte --}}
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title fw-bold text-truncate" title="{{ $realisation->titre }}">
                        {{ $realisation->titre }}
                    </h5>
                    <p class="card-text text-muted small">
                        {{-- Exemple de description courte ou lieu d’installation --}}
                        {{ Str::limit($realisation->description, 80) }}
                    </p>
                    <div class="mt-auto">
                        <button class="btn btn-primary rounded-pill px-4">
                            <a wire:navigate href="{{ route('detail-realisation', $realisation->id)}}" class="text-white text-decoration-none">
                                En savoir plus
                            </a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>