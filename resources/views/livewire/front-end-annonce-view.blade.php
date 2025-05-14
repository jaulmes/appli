<div 
  class="position-fixed bottom-0 start-0 shadow rounded-3 overflow-hidden d-flex align-items-center mb-3 ms-3 bg-white"
  style="width: 18em; z-index: 1050;"
>
    @if($voir_annonce === true)
        <div class="position-relative w-100">
            <!-- Bouton Fermer -->
            <button type="button"
                wire:click="toggleVoirAnnonce"
                class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                style="z-index: 2000;"
                aria-label="Fermer">
            </button>

            <!-- Carousel Bootstrap -->
            <div id="carouselAnnonces" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="7000">
                <div class="carousel-inner">
                    @foreach($annonces as $index => $annonce)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/images/annonces/'.$annonce->image) }}"
                                class="d-block w-100 rounded"
                                style="height: 150px; object-fit: cover;"
                                alt="Annonce {{ $index + 1 }}">

                            <!-- Lien Acheter -->
                            @if($annonce->produit_id)
                                <a href="{{ route('produit-detail', $annonce->produit_id) }}"
                                   class="btn btn-sm btn-danger position-absolute bottom-0 end-0 m-2">
                                    Acheter
                                </a>
                            @elseif($annonce->service_id)
                                <a href="{{ route('detail-service', $annonce->service_id) }}"
                                   class="btn btn-sm btn-danger position-absolute bottom-0 end-0 m-2">
                                    Acheter
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
