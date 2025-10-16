<!-- livewire/navigation-header.blade.php -->
<div>
    <header class="fixed-top">
        <!-- Première barre -->
        <div class="bg-dark text-white" style="padding-top: 3em; padding-bottom: 0.5em;">
            <div class="container-fluid">
                <!-- Version Mobile -->
                <div class="d-lg-none d-flex align-items-center justify-content-between">
                    <!-- Logo -->
                    <a href="{{ route('frontend.index') }}" class="d-flex align-items-center">
                        <img src="{{ asset('logo.jpg') }}" alt="Logo Solergy Solutions" style="height:35px;">
                    </a>

                    <!-- Boutons mobiles -->
                    <div class="d-flex align-items-center gap-2">
                        <!-- Bouton recherche mobile -->
                        <button class="btn btn-link text-white p-1"
                            data-bs-toggle="collapse"
                            data-bs-target="#mobileSearch">
                            <i class="fas fa-search"></i>
                        </button>

                        <!-- Panier mobile -->
                        <button class="btn btn-link text-white position-relative p-1"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#cartOffcanvas">
                            <i class="fas fa-shopping-cart"></i>
                            @if($qte > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark" style="font-size: 0.6em;">
                                {{ $qte }}
                            </span>
                            @endif
                        </button>

                        <!-- Menu hamburger -->
                        <button class="btn btn-link text-white p-1"
                            data-bs-toggle="collapse"
                            data-bs-target="#mobileMenu">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>

                <!-- Version Desktop -->
                <div class="d-none d-lg-flex align-items-center justify-content-between">
                    <!-- Logo -->
                    <a href="{{ route('frontend.index') }}" class="d-flex align-items-center">
                        <img src="{{ asset('logo.jpg') }}" alt="Logo Solergy Solutions" style="height:40px;">
                    </a>

                    <!-- Email et localisation -->
                    <div class="d-flex flex-column ms-3">
                        <small>solutionssolergy@gmail.com</small>
                        <span class="fw-bold"><i class="fas fa-map-marker-alt me-1"></i> Cameroun, Douala</span>
                    </div>

                    <!-- Barre de recherche -->
                    <div class="flex-grow-1 mx-3">
                        <livewire:front-end-search-bar />
                    </div>

                    <!-- Liens à droite -->
                    <div class="d-flex align-items-center gap-4">
                        <!-- Contact -->
                        <div class="text-nowrap">
                            <small>(+237) 6 57 24 89 25</small>
                        </div>

                        <!-- Panier -->
                        <button class="btn btn-link text-white position-relative"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#cartOffcanvas">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                            @if($qte > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                                {{ $qte }}
                            </span>
                            @endif
                            <span class="fw-bold ms-1 d-none d-xl-inline">Panier</span>
                        </button>
                    </div>
                </div>

                <!-- Barre de recherche mobile (collapse) -->
                <div class="collapse d-lg-none mt-3" id="mobileSearch">
                    <livewire:front-end-search-bar />
                </div>
            </div>
        </div>

        <!-- Deuxième barre - Navigation -->
        <nav class="text-white" style="background-color: #41dd63ff;">
            <div class="container-fluid">
                <!-- Navigation Desktop -->
                <div class="d-none d-lg-flex justify-content-center gap-4 py-2">
                    <a href="{{ route('frontend.index') }}" class="fw-bold text-white text-decoration-none">
                        <i class="fas fa-bars me-1"></i> Toutes
                    </a>
                    <a href="{{ route('all-produit') }}" class="text-white text-decoration-none">Produits</a>
                    <a href="{{ route('all-realisations') }}" class="text-white text-decoration-none">Réalisations</a>
                    <a href="{{ route('allPromoProduit') }}" class="text-white text-decoration-none">Promotions</a>
                    <a href="{{ route('all-pack') }}" class="text-white text-decoration-none">Packs produits</a>
                    <a href="{{ route('all-categorie') }}" class="text-white text-decoration-none">Categories</a>
                    <a href="{{ route('nos-services') }}" class="text-white text-decoration-none">Services</a>
                    <a href="{{ route('simulateur') }}" class="text-white text-decoration-none">Simulateur</a>
                    <a href="{{ route('a-propos-de-nous') }}" class="text-white text-decoration-none">Contact</a>
                </div>

                <!-- Navigation Mobile (collapse) -->
                <div class="collapse d-lg-none" id="mobileMenu">
                    <div class="py-2">
                        <a href="{{ route('frontend.index') }}" class="d-block fw-bold text-white text-decoration-none py-2 border-bottom border-light border-opacity-25">
                            <i class="fas fa-bars me-2"></i> Toutes
                        </a>
                        <a href="{{ route('all-produit') }}" class="d-block text-white text-decoration-none py-2 border-bottom border-light border-opacity-25">
                            Produits
                        </a>
                        <a href="{{ route('all-realisations') }}" class="d-block text-white text-decoration-none py-2 border-bottom border-light border-opacity-25">
                            Réalisations
                        </a>
                        <a href="{{ route('allPromoProduit') }}" class="d-block text-white text-decoration-none py-2 border-bottom border-light border-opacity-25">
                            Promotions
                        </a>
                        <a href="{{ route('all-pack') }}" class="d-block text-white text-decoration-none py-2 border-bottom border-light border-opacity-25">
                            Packs produits
                        </a>
                        <a href="{{ route('all-categorie') }}" class="d-block text-white text-decoration-none py-2 border-bottom border-light border-opacity-25">
                            Categories
                        </a>
                        <a href="{{ route('nos-services') }}" class="d-block text-white text-decoration-none py-2 border-bottom border-light border-opacity-25">
                            Services
                        </a>
                        <a href="{{ route('simulateur') }}" class="d-block text-white text-decoration-none py-2 border-bottom border-light border-opacity-25">
                            Simulateur
                        </a>
                        <a href="{{ route('a-propos-de-nous') }}" class="d-block text-white text-decoration-none py-2">
                            Contact
                        </a>

                        <!-- Infos de contact en mobile -->
                        <div class="mt-3 pt-3 border-top border-light border-opacity-25">
                            <div class="text-center mb-2">
                                <small>solutionssolergy@gmail.com</small>
                            </div>
                            <div class="text-center mb-2">
                                <small><i class="fas fa-map-marker-alt me-1"></i> Cameroun, Douala</small>
                            </div>
                            <div class="text-center">
                                <small><i class="fas fa-phone me-1"></i> (+237) 6 57 24 89 25</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Offcanvas Panier -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">Mon Panier</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <livewire:front-end-cart />
        </div>
    </div>

    @push('styles')
    <style>
        header {
            font-size: 14px;
            z-index: 1030;
        }

        .bg-dark {
            background-color: #131921 !important;
        }

        .btn-warning {
            background-color: #febd69;
            border-color: #febd69;
        }

        .btn-warning:hover {
            background-color: #f3a847;
            border-color: #f3a847;
        }

        /* Responsive adjustments */
        @media (max-width: 575.98px) {
            header {
                font-size: 13px;
            }

            .container-fluid {
                padding-left: 10px;
                padding-right: 10px;
            }
        }

        @media (max-width: 767.98px) {

            /* Réduire le padding vertical sur mobile */
            .bg-dark {
                padding-top: 2.5em !important;
                padding-bottom: 0.3em !important;
            }

            /* Ajuster la taille du logo sur mobile */
            .bg-dark img {
                height: 32px !important;
            }
        }

        @media (min-width: 768px) and (max-width: 991.98px) {

            /* Tablettes */
            .gap-4 {
                gap: 1rem !important;
            }

            header {
                font-size: 13px;
            }
        }

        @media (min-width: 992px) and (max-width: 1199.98px) {

            /* Desktop small */
            .gap-4 {
                gap: 1.5rem !important;
            }
        }

        /* Menu mobile animations */
        .collapse {
            transition: all 0.3s ease-in-out;
        }

        /* Améliorer l'apparence des boutons mobiles */
        .btn-link:hover {
            color: #41dd63ff !important;
        }

        /* Assurer que le menu mobile ne déborde pas */
        #mobileMenu a {
            font-size: 14px;
            padding-left: 1rem;
            padding-right: 1rem;
        }
    </style>
    @endpush
</div>