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
        <style>
/* ——————————————————————————————————————————————————————————————————
   1) Fond dégradé animé
—————————————————————————————————————————————————————————————————— */
.topbar {
  background: linear-gradient(
    270deg,
    #0066ff,
    #00ccff,
    #6600cc,
    #ff0066
  );
  background-size: 800% 800%;
  animation: gradientShift 20s ease infinite;
  overflow: hidden;
  position: relative;
  z-index: 999;
}

@keyframes gradientShift {
  0%   { background-position: 0%   50%; }
  50%  { background-position: 100% 50%; }
  100% { background-position: 0%   50%; }
}


/* ——————————————————————————————————————————————————————————————————
   2) Apparition en cascade des items
—————————————————————————————————————————————————————————————————— */
.topbar .top-info .d-flex,
.topbar .top-link .d-flex {
  opacity: 0;
  transform: translateY(-20px);
  animation: fadeInDown 0.8s forwards;
}

/* Staggering */
.topbar .top-info .d-flex:nth-child(1) { animation-delay: 0.2s; }
.topbar .top-info .d-flex:nth-child(2) { animation-delay: 0.4s; }
.topbar .top-link .d-flex:nth-child(1) { animation-delay: 0.6s; }
.topbar .top-link .d-flex:nth-child(2) { animation-delay: 0.8s; }

@keyframes fadeInDown {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}


/* ——————————————————————————————————————————————————————————————————
   3) Icônes flottantes
—————————————————————————————————————————————————————————————————— */
.topbar i {
  display: inline-block;
  animation: float 3s ease-in-out infinite;
}

@keyframes float {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-4px);
  }
}


/* ——————————————————————————————————————————————————————————————————
   4) Hover stylé sur les liens
—————————————————————————————————————————————————————————————————— */
.topbar a {
  position: relative;
  color: #fff;
  transition: color 0.3s ease;
}

.topbar a::after {
  content: "";
  position: absolute;
  left: 50%;
  bottom: -2px;
  width: 0;
  height: 2px;
  background: #ffeb3b;
  transition: all 0.3s ease;
}

.topbar a:hover {
  color: #ffeb3b;
}

.topbar a:hover::after {
  left: 0;
  width: 100%;
}


/* ——————————————————————————————————————————————————————————————————
   5) Option : légère ombre portée
—————————————————————————————————————————————————————————————————— */
.topbar {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}
</style>

    </div>

    <!-- Navbar principale -->
    <div class="container px-0">
        <nav class="navbar navbar-expand-xl navbar-light bg-white shadow-sm">
            <!-- Logo -->
            <a href="{{ route('frontend.index') }}" class="navbar-brand">
                <img src="{{ asset('logo.jpg') }}" alt="Logo Solergy Solutions SARL" style="width: 100px; height: 80px;">
            </a>

            <!-- Bouton Burger -->
            <div class="d-flex align-items-center">
              <!-- Icône du panier pour mobile, positionnée à côté du burger -->
              <button class="position-relative border-0 bg-transparent ms-2 d-md-none" 
                        data-bs-toggle="offcanvas" 
                        data-bs-target="#cartOffcanvas" 
                        aria-controls="cartOffcanvas">
                        
                  <i class="fa fa-shopping-bag fa-lg "></i>
                  <span class="position-absolute top-0 start-100 translate-middle bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                        style="height: 16px; min-width: 16px; font-size: 10px;">
                      {{$qte}}
                  </span>
              </button>

              <!-- Burger visible sur mobile -->
              <button class="navbar-toggler py-2 px-3 border-0 d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                  <span class="fa fa-bars "></span>
              </button>
            </div>

            <!-- Contenu collapsible -->
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a href="{{ route('frontend.index') }}" class="nav-link active">Accueil</a></li>
                    <li class="nav-item"><a href="{{ route('all-produit')}}" class="nav-link">Produits</a></li>
                    <li class="nav-item"><a href="{{ route('all-realisations') }}" class="nav-link">realisations</a></li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                        <ul class="dropdown-menu bg-secondary rounded-0">
                            <li><a href="#" class="dropdown-item">blog</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a href="#contact" class="nav-link">Contact</a></li>

                    <li class="nav-item"><a href="{{ route('simulateur')}}" class="nav-link">Simulateur <i class="fas fa-calculator"></i></a></li>
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
