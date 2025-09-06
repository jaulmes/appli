<!-- livewire/navigation-header.blade.php -->
 <div>
<header class="fixed-top">
    <!-- Première barre -->
    <div class="bg-dark text-white py-2">
        <div class="container-fluid d-flex align-items-center justify-content-between">

            <!-- Logo -->
            <a href="{{ route('frontend.index') }}" class="d-flex align-items-center">
                <img src="{{ asset('logo.jpg') }}" alt="Logo Solergy Solutions" style="height:40px;">
            </a>

            <!-- email et localisation -->
            <div class="d-none d-lg-flex flex-column ms-3">
                <small>solutionssolergy@gmail.com</small>
                <span class="fw-bold"><i class="fas fa-map-marker-alt me-1"></i> Cameroun, Douala</span>
            </div>

            <!-- Barre de recherche -->
            <div class="flex-grow-1 mx-3 d-none d-lg-block">
                <livewire:front-end-search-bar />
            </div>

            <!-- Liens à droite -->
            <div class="d-flex align-items-center gap-4">
                <!-- contact -->
                <div>(+237)
                    <small> 6 57 24 89 25</small>
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
                    <span class="fw-bold ms-1">Panier</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Deuxième barre -->
    <nav class="bg-secondary text-white">
        <div class="container-fluid d-flex gap-4 py-2">
            <a href="{{ route('frontend.index') }}" class="fw-bold text-white text-decoration-none">
                <i class="fas fa-bars me-1"></i> Toutes
            </a>
            <a href="{{ route('all-produit') }}" class="text-white text-decoration-none">Produits</a>
            <a href="{{ route('all-realisations') }}" class="text-white text-decoration-none">Réalisations</a>
            <a href="{{ route('allPromoProduit') }}" class="text-white text-decoration-none">Promotions</a>
            <a href="{{ route('all-pack') }}" class="text-white text-decoration-none">Packs produits</a>
            <a href="{{ route('nos-services') }}" class="text-white text-decoration-none">Services</a>
            <a href="{{ route('simulateur') }}" class="text-white text-decoration-none">Simulateur</a>
            <a href="{{ route('a-propos-de-nous') }}" class="text-white text-decoration-none">Contact</a>
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
    }
    .bg-dark {
        background-color: #131921 !important; /* style Amazon */
    }
    .bg-secondary {
        background-color: #232f3e !important; /* barre secondaire Amazon */
    }
    .btn-warning {
        background-color: #febd69;
        border-color: #febd69;
    }
    .btn-warning:hover {
        background-color: #f3a847;
        border-color: #f3a847;
    }
</style>
@endpush
 </div>

