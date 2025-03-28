<div>
<div class="container-fluid py-5 position-relative bg-light">
    {{-- Arrière-plan décoratif (formes / angles) --}}
    <div class="bg-shapes-top position-absolute start-0 top-0"></div>
    <div class="bg-shapes-bottom position-absolute end-0 bottom-0"></div>

    {{-- Titre de la section --}}
    <div class="text-center mb-5">
        <h6 class="text-warning fw-bold mb-2" style="letter-spacing: 2px;">RÉALISATIONS</h6>
        <h2 class="fw-bold display-6 text-uppercase" style="color: #004075;">
            TOUT POUR ÉNERGIE SOLAIRE
        </h2>
    </div>

    {{-- Liste des réalisations : 4 cartes par ligne --}}
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
                                    <img 
                                        src="{{ asset('storage/images/realisations/' .$image) }}" 
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
                                En savoir plus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Bouton principal en bas de la section --}}
    <div class="text-center mt-5">
        <button class="btn btn-warning text-dark rounded-pill px-4 py-2 shadow">
            Découvrir plus
        </button>
    </div>
</div>

{{-- Exemple de styles personnalisés --}}
<style>
    /* Optionnel : ajustez les couleurs / formes selon vos besoins */

    .bg-light {
        background-color: #f8f9fa !important;
    }

    /* Exemples de "formes" en arrière-plan : 
       vous pouvez remplacer ces pseudo-éléments par des images SVG, 
       ou un background-image, etc. */
    .bg-shapes-top::before,
    .bg-shapes-bottom::before {
        content: "";
        position: absolute;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle at center, #ffa500 0%, #ff7f00 100%);
        opacity: 0.3;
        z-index: -1;
    }

    /* Forme en haut à gauche */
    .bg-shapes-top::before {
        top: -50px;
        left: -50px;
        border-radius: 50%;
    }

    .bg-shapes-top {
        width: 0; 
        height: 0;
    }

    /* Forme en bas à droite */
    .bg-shapes-bottom::before {
        bottom: -50px;
        right: -50px;
        border-radius: 50%;
    }

    .bg-shapes-bottom {
        width: 0; 
        height: 0;
    }

    /* Ajustement du titre secondaire (RÉALISATIONS) */
    h6.text-warning {
        font-size: 0.9rem;
        text-transform: uppercase;
    }

    /* Ajustement du bouton "En savoir plus" */
    .btn-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
        border: none;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #0056b3, #003f7f);
    }

    /* Ajustement du bouton "Découvrir plus" */
    .btn-warning {
        background: linear-gradient(135deg, #ffaf00, #ff7f00);
        border: none;
    }
    .btn-warning:hover {
        background: linear-gradient(135deg, #ff7f00, #ff5a00);
    }

    /* Pour assurer un bel affichage de l'image */
    .object-fit-cover {
        object-fit: cover;
    }
</style>

</div>
