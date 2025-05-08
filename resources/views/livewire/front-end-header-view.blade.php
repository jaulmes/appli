<!-- livewire/navigation-header.blade.php -->
<div class="container-fluid fixed-top bg-white shadow-sm">
    <!-- Top Bar -->
    <div class="bg-dark text-white py-2 mb-4 d-none d-lg-block">
        <div class="container d-flex justify-content-between align-items-center flex-wrap">
            <!-- Coordonnées -->
            <div class="d-flex flex-wrap align-items-center gap-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-map-marker-alt me-2"></i>
                <a href="https://maps.google.com/?q=Collège Bénédicte, Ndockoti, Douala, Cameroun" target="_blank" class="text-white text-decoration-none">
                <span class="d-none d-sm-inline">En face Collège Bénédicte, Ndockoti, Douala</span>
                <span class="d-inline d-sm-none">Douala</span>
                </a>
            </div>
            <div class="d-flex align-items-center">
                <i class="fas fa-envelope me-2"></i>
                <a href="mailto:solutionssolergy@gmail.com" class="text-white text-decoration-none">
                <span class="d-none d-md-inline">solutionssolergy@gmail.com</span>
                <span class="d-inline d-md-none">Email</span>
                </a>
            </div>
            </div>

            <!-- Téléphone et liens -->
            <div class="d-flex flex-wrap align-items-center gap-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-phone-alt me-2"></i>
                <a href="tel:+237657248925" class="text-white text-decoration-none">+237 6 57 24 89 25</a>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="#" class="text-white text-decoration-none">Conditions</a>
                <a href="#" class="text-white text-decoration-none">Politique</a>
            </div>
            </div>
        </div>
    </div>


    <!-- Navbar principale -->
    <div class="container px-0">
        <!-- Barre de recherche visible uniquement sur desktop -->
        <div class="d-none d-lg-block mx-auto my-1" style="max-width: 400px;">
            <livewire:front-end-search-bar />
        </div>


        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <!-- Logo -->
            <a href="{{ route('frontend.index') }}" class="navbar-brand py-2">
                <img src="{{  asset('logo.jpg') }}" 
                     alt="Logo Solergy Solutions" 
                     class="img-fluid" 
                     style="height: 50px; width: auto;">
            </a>

            <!--panier flottant sur mobile-->
            <div class="panier-flottant d-lg-none" style="position:absolute; margin-top:63em; margin-left: 18.5em;">
                <button class="btn btn-link position-relative p-2 me-2 " 
                        data-bs-toggle="offcanvas" 
                        data-bs-target="#cartOffcanvas"
                        >
                    <i class="bi bi-bag-fill" style="height: 50px; font-size:xx-large"></i>
                    @if($qte > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $qte }}
                        </span>
                    @endif
                </button>
            </div>

            <!--panier flottant sur pc-->
            <div class="panier-flottant d-none d-lg-block" style="position:absolute; margin-top:59em; margin-left: 88.5em;">
                <button class="btn btn-link position-relative p-2 me-2 " 
                        data-bs-toggle="offcanvas" 
                        data-bs-target="#cartOffcanvas"
                        >
                    <i class="bi bi-bag-fill" style="height: 50px; font-size:xx-large"></i>
                    @if($qte > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $qte }}
                        </span>
                    @endif
                </button>
            </div>
            

            <!-- Boutons mobiles -->
            <div class="d-flex align-items-center order-lg-3 ms-auto ms-lg-0">
                <!-- Panier mobile -->
                <button class="btn btn-link position-relative p-2 me-2 d-lg-none" 
                        data-bs-toggle="offcanvas" 
                        data-bs-target="#cartOffcanvas">
                    <i class="fas fa-shopping-bag text-primary"></i>
                    @if($qte > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $qte }}
                        </span>
                    @endif
                </button>
                
                <!-- Connexion mobile -->
                <a href="{{ route('login') }}"  class="btn btn-sm btn-primary me-2 d-lg-none">
                    <i class="fas fa-sign-in-alt d-inline d-sm-none"></i>
                    <span class="d-none d-sm-inline">Connexion</span>
                </a>

                <!-- Burger -->
                <button class="navbar-toggler border-0 p-2" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#navbarCollapse">
                    <span class="fas fa-bars text-primary"></span>
                </button>
            </div>

            <!-- Contenu collapsible -->
            <div class=" bg-white collapse navbar-collapse order-lg-2" id="navbarCollapse">
                <ul class="navbar-nav mx-auto mt-3 mt-lg-0">
                    <li class="nav-item">
                        <a href="{{ route('frontend.index') }}" 
                           class="nav-link {{ request()->routeIs('frontend.index') ? 'active fw-bold' : '' }}">
                            Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('all-produit') }}" 
                           class="nav-link {{ request()->routeIs('all-produit') ? 'active fw-bold' : '' }}">
                            Produits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('all-realisations') }}" 
                           class="nav-link {{ request()->routeIs('all-realisations') ? 'active fw-bold' : '' }}">
                            Réalisations
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            Pages
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Blog</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#contact" 
                           class="nav-link">
                            Contact
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('simulateur') }}" 
                           class="nav-link {{ request()->routeIs('simulateur') ? 'active fw-bold' : '' }}">
                            <i class="fas fa-calculator me-1"></i>Simulateur
                        </a>
                    </li>
                </ul>


                <!-- Section droite desktop -->
                <div class="d-flex align-items-center ms-lg-auto mt-3 mt-lg-0 order-lg-3">
                    <!-- Panier desktop -->
                    <button class="btn btn-link position-relative p-2 me-3 d-none d-lg-block" 
                            data-bs-toggle="offcanvas" 
                            data-bs-target="#cartOffcanvas">
                        <i class="fas fa-shopping-bag fa-lg text-primary"></i>
                        @if($qte > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $qte }}
                            </span>
                        @endif
                    </button>
                    
                    <!-- Connexion desktop -->
                    <a href="{{ route('login') }}" target="_blank" class="btn btn-primary d-none d-lg-block">
                        <i class="fas fa-sign-in-alt me-1"></i>Connexion
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- Offcanvas Panier -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">Mon Panier</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <livewire:front-end-cart />
        </div>
    </div>@push('styles')
<style>
    /* Animation gradient topbar */
    .topbar {
        background: linear-gradient(270deg, #0066ff, #00ccff, #6600cc, #ff0066);
        background-size: 800% 800%;
        animation: gradientShift 20s ease infinite;
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Navigation active state */
    .navbar-nav .nav-link.active {
        color: var(--bs-primary);
        position: relative;
    }

    .navbar-nav .nav-link.active:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 2px;
        background: var(--bs-primary);
    }

    /* Mobile optimizations */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            padding: 1rem;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }
        
        .nav-item {
            margin-bottom: 0.5rem;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .nav-link {
            padding: 0.75rem 0;
        }
    }

    /* Smooth transitions */
    .navbar-brand img {
        transition: transform 0.3s ease;
    }
    
    .navbar-brand:hover img {
        transform: scale(1.05);
    }
</style>
@endpush
</div>

