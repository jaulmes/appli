<div class="container-fluid fixed-top">
    <!-- Top Bar -->
    <div class="topbar d-none d-lg-block" style="background-color: blue;">
        <div class="container">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center py-2">
                <div class="top-info d-flex flex-wrap justify-content-center justify-content-lg-start mb-2 mb-lg-0">
                    <div class="d-flex align-items-center me-3">
                        <i class="fas fa-map-marker-alt me-2 text-white"></i>
                        <a href="https://maps.google.com/?q=Collège Bénédicte, Ndockoti, Douala, Cameroun" 
                           class="text-white text-decoration-none small"
                           target="_blank" rel="noopener noreferrer">
                            En face Collège Bénédicte, Ndockoti, Douala
                        </a>
                    </div>
                    <div class="d-flex align-items-center me-3">
                        <i class="fas fa-envelope me-2 text-white"></i>
                        <a href="mailto:solutionssolergy@gmail.com" 
                           class="text-white text-decoration-none small">
                            solutionssolergy@gmail.com
                        </a>
                    </div>
                </div>
                
                <div class="top-link d-flex flex-wrap justify-content-center">
                    <div class="d-flex align-items-center me-3">
                        <i class="fas fa-phone-alt me-2 text-white"></i>
                        <a href="tel:+237657248925" 
                           class="text-white text-decoration-none small">
                            +237 6 57 24 89 25
                        </a>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="#" class="text-white text-decoration-none small me-3">Conditions d'utilisation</a>
                        <a href="#" class="text-white text-decoration-none small">Politique de vente</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar principale -->
    <div class="container px-0">
        <nav class="navbar navbar-expand-xl navbar-light bg-white shadow-sm">
            <!-- Logo -->
            <a href="#" class="navbar-brand">
                <img src="{{ asset('logo.jpg') }}" alt="Logo Solergy Solutions SARL" style="width: 100px; height: 80px;">
            </a>

            <!-- Bouton Burger -->
            <div class="d-flex align-items-center">
                <!-- Burger visible sur mobile -->
                <button class="navbar-toggler py-2 px-3 border-0 d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <!-- Icône du panier pour mobile, positionnée à côté du burger -->
                <button class="position-relative border-0 bg-transparent ms-2 d-md-none" 
                        data-bs-toggle="offcanvas" 
                        data-bs-target="#cartOffcanvas" 
                        aria-controls="cartOffcanvas">
                    <i class="fa fa-shopping-bag fa-lg text-primary"></i>
                    <span class="position-absolute top-0 start-100 translate-middle bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                          style="height: 16px; min-width: 16px; font-size: 10px;">
                        {{$qte}}
                    </span>
                </button>
            </div>

            <!-- Contenu collapsible -->
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a href="index.html" class="nav-link active">Accueil</a></li>
                    <li class="nav-item"><a href="shop.html" class="nav-link">Produits</a></li>
                    <li class="nav-item"><a href="shop-detail.html" class="nav-link">Détails</a></li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                        <ul class="dropdown-menu bg-secondary rounded-0">
                            <li><a href="cart.html" class="dropdown-item">Panier</a></li>
                            <li><a href="checkout.html" class="dropdown-item">Paiement</a></li>
                            <li><a href="testimonial.html" class="dropdown-item">Témoignages</a></li>
                            <li><a href="404.html" class="dropdown-item">Erreur 404</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li>
                </ul>

                <!-- Section Panier & Connexion pour écrans moyens et grands -->
                <div class="d-flex align-items-center ms-auto d-none d-md-flex">
                    <!-- Bouton Panier Desktop -->
                    <button class="position-relative border-0 bg-transparent me-4" 
                            data-bs-toggle="offcanvas" 
                            data-bs-target="#cartOffcanvas" 
                            aria-controls="cartOffcanvas">
                        <i class="fa fa-shopping-bag fa-2x text-primary"></i>
                        <span class="position-absolute top-0 start-100 translate-middle bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                              style="height: 20px; min-width: 20px; font-size: 12px;">
                            {{$qte}}
                        </span>
                    </button>
                    <!-- Bouton Connexion -->
                    <a href="#" class="btn btn-primary">Se connecter</a>
                </div>
            </div>
        </nav>
    </div>

    <!-- Offcanvas Panier -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="cartOffcanvasLabel">Mon Panier</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
        </div>
        <div class="offcanvas-body">
            <livewire:front-end-cart/>
        </div>
    </div>
</div>
