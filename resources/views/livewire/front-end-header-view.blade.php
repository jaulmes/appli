<!-- livewire/navigation-header.blade.php -->
<div class="container-fluid fixed-top bg-white shadow-sm">
    <!-- Top Bar -->
    <div class="topbar d-none d-lg-block">
    <div class="container">
        <div class="row g-2 py-0 align-items-center">
            <!-- Colonne gauche - Coordonnées -->
            <div class="col-lg-6">
                <div class="d-flex flex-wrap justify-content-center justify-content-lg-start">
                    <!-- Bloc Adresse -->
                    <div class="contact-item me-3 mb-1 mb-lg-0">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        <a href="https://maps.google.com/?q=Collège Bénédicte, Ndockoti, Douala, Cameroun" 
                           class="text-white text-decoration-none" 
                           target="_blank">
                            <span class="d-none d-sm-inline">En face Collège Bénédicte, Ndockoti, Douala</span>
                            <span class="d-inline d-sm-none">Douala</span>
                        </a>
                    </div>
                    
                    <!-- Bloc Email -->
                    <div class="contact-item">
                        <i class="fas fa-envelope me-1"></i>
                        <a href="mailto:solutionssolergy@gmail.com" 
                           class="text-white text-decoration-none">
                            <span class="d-none d-md-inline">solutionssolergy@gmail.com</span>
                            <span class="d-inline d-md-none">Email</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Colonne droite - Contacts et liens -->
            <div class="col-lg-6">
                <div class="d-flex flex-wrap justify-content-center justify-content-lg-end">
                    <!-- Bloc Téléphone -->
                    <div class="contact-item me-3 mb-1 mb-lg-0">
                        <i class="fas fa-phone-alt me-1"></i>
                        <a href="tel:+237657248925" class="text-white text-decoration-none">
                            +237 6 57 24 89 25
                        </a>
                    </div>
                    
                    <!-- Liens secondaires -->
                    <div class="d-flex">
                        <div class="contact-item me-2">
                            <a href="#" class="text-white text-decoration-none">
                                <span class="d-none d-lg-inline">Conditions</span>
                                <span class="d-inline d-lg-none">CGU</span>
                            </a>
                        </div>
                        <div class="contact-item">
                            <a href="#" class="text-white text-decoration-none">
                                <span class="d-none d-lg-inline">Politique</span>
                                <span class="d-inline d-lg-none">Pol.</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animation gradient */
    .topbar {
        background: linear-gradient(270deg, #0066ff, #00ccff, #6600cc, #ff0066);
        background-size: 800% 800%;
        animation: gradientShift 20s ease infinite;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        position: relative;
        z-index: 999;
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Style des éléments de contact */
    .contact-item {
        display: flex;
        align-items: center;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateY(-10px);
        animation: fadeInDown 0.6s forwards;
    }

    /* Animation en cascade */
    .contact-item:nth-child(1) { animation-delay: 0.2s; }
    .contact-item:nth-child(2) { animation-delay: 0.4s; }
    .contact-item:nth-child(3) { animation-delay: 0.6s; }
    .contact-item:nth-child(4) { animation-delay: 0.8s; }

    @keyframes fadeInDown {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Icônes animées */
    .topbar i {
        display: inline-block;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
    }

    /* Style des liens */
    .topbar a {
        position: relative;
        color: #fff;
        font-size: 0.875rem;
        white-space: nowrap;
        transition: color 0.3s ease;
    }

    .topbar a::after {
        content: "";
        position: absolute;
        left: 50%;
        bottom: -2px;
        width: 0;
        height: 1px;
        background: #ffeb3b;
        transition: all 0.3s ease;
    }

    .topbar a:hover {
        color: #ffeb3b;
        text-decoration: none;
    }

    .topbar a:hover::after {
        left: 0;
        width: 100%;
    }

    /* Optimisations mobile */
    @media (max-width: 991.98px) {
        .contact-item {
            padding: 0.2rem 0.4rem;
        }
        
        .topbar a {
            font-size: 0.8rem;
        }
        
        .topbar i {
            font-size: 0.9rem;
        }
    }
</style>

    <!-- Navbar principale -->
    <div class="container px-0">
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <!-- Logo -->
            <a href="{{ route('frontend.index') }}" class="navbar-brand py-2">
                <img src="{{  asset('logo.jpg') }}" 
                     alt="Logo Solergy Solutions" 
                     class="img-fluid" 
                     style="height: 50px; width: auto;">
            </a>

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
                <a href="{{ route('login') }}" class="btn btn-sm btn-primary me-2 d-lg-none">
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
                    <a href="{{ route('login') }}" class="btn btn-primary d-none d-lg-block">
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

