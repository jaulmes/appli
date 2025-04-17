<div>
    <div class="container-fluid py-5 position-relative bg-light overflow-hidden">
        {{-- Arrière-plan animé --}}
        <div class="bg-shapes-top position-absolute start-0 top-0"></div>
        <div class="bg-shapes-bottom position-absolute end-0 bottom-0"></div>

        {{-- Titre de la section --}}
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-warning fw-bold mb-2 label-animation" style="letter-spacing: 2px;">RÉALISATIONS</h6>
            <h2 class="fw-bold display-6 text-uppercase title-animation" style="color: #004075;">
            Nos Réalisations Solaires : La Preuve par l'Exemple
            </h2>
        </div>

        {{-- Liste des réalisations --}}
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
                <div class="col-sm-6 col-md-4 col-lg-3" data-aos="flip-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden hover-3d">
                        {{-- Carousel amélioré --}}
                        <div id="carouselRealisation{{ $realisation->id }}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($images as $key => $image)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <div class="image-wrapper">
                                            <img 
                                                src="{{ asset('storage/images/Realisations/' .$image) }}" 
                                                alt="Image de la réalisation"
                                                class="d-block w-100 object-fit-cover zoom-image"
                                                style="height: 200px;"
                                            >
                                            <div class="image-overlay"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if(count($images) > 1)
                            <div class="carousel-controls">
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselRealisation{{ $realisation->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Précédent</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselRealisation{{ $realisation->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Suivant</span>
                                </button>
                            </div>
                            <div class="carousel-progress">
                                <div class="progress-bar"></div>
                            </div>
                            @endif
                        </div>
                        
                        {{-- Corps de la carte --}}
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title fw-bold text-truncate gradient-text">
                                {{ $realisation->titre }}
                            </h5>
                            <p class="card-text text-muted small">
                                {{ Str::limit($realisation->description, 80) }}
                            </p>
                            <div class="mt-auto">
                                <button class="btn btn-primary rounded-pill px-4 shine-hover">
                                    <a wire:navigate href="{{ route('detail-realisation', $realisation->id)}}" class="text-white text-decoration-none">
                                        En savoir plus <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Bouton principal --}}
        <div class="text-center mt-5" data-aos="zoom-in">
            <a href="{{ route('all-realisations') }}" class="text-decoration-none">
                <button class="btn btn-primary text-white rounded-pill px-4 py-2 shadow magnetic-effect">
                    Voir toutes nos réalisations
                    <span class="hover-effect"></span>
                </button>
            </a>
        </div>
    </div>

    <style>
        /* Animations de base */
        .hover-3d {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), 
                        box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-3d:hover {
            transform: translateY(-10px) rotateX(5deg) rotateY(5deg);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        }

        /* Overlay image */
        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, rgba(0,0,0,0) 50%, rgba(0,0,0,0.6) 100%);
            transition: opacity 0.3s;
        }

        /* Zoom image au survol */
        .zoom-image {
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .carousel-item:hover .zoom-image {
            transform: scale(1.1);
        }

        /* Barre de progression carousel */
        .carousel-progress {
            height: 3px;
            background: rgba(255,255,255,0.2);
            position: relative;
        }

        .progress-bar {
            height: 100%;
            width: 0;
            background: #fff;
            transition: width 5s linear;
        }

        .carousel:hover .progress-bar {
            animation: progress 5s linear;
        }

        @keyframes progress {
            from { width: 0; }
            to { width: 100%; }
        }

        /* Effet "shine" sur les boutons */
        .shine-hover {
            position: relative;
            overflow: hidden;
        }

        .shine-hover::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent,
                rgba(255,255,255,0.3),
                transparent
            );
            transform: rotate(45deg);
            transition: all 0.6s;
            opacity: 0;
        }

        .shine-hover:hover::after {
            opacity: 1;
            animation: shine 1.5s;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        /* Effet magnétique sur le bouton principal */
        .magnetic-effect {
            position: relative;
            transition: all 0.3s ease-out;
        }

        .magnetic-effect:hover {
            transform: scale(1.05) rotate(2deg);
        }

        /* Formes décoratives animées */
        .bg-shapes-top::before,
        .bg-shapes-bottom::before {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* Texte dégradé */
        .gradient-text {
            background: linear-gradient(45deg, #004075, #007bff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
    </style>
</div>