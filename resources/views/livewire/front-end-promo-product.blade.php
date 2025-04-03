<div class="container py-5">
    <div class="tab-class text-center">
        <div class="row g-4 bg-grey align-items-center mb-5">
            <div class="col-lg-4 text-start">
                <h1>Nos Promotions</h1>
            </div>
            <div class="col-lg-8 text-end">
                <ul class="nav nav-pills d-inline-flex mb-0">
                    <li class="nav-item">
                        <a href="{{ route('allPromoProduit') }}" wire:navigate class="btn btn-dark rounded-pill">
                            Voir plus
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div id="carouselProduits" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <!-- Indicateurs du carousel -->
                <div class="carousel-indicators">
                    @foreach($produits->chunk(4) as $chunkIndex => $chunk)
                        <button type="button" data-bs-target="#carouselProduits" data-bs-slide-to="{{ $chunkIndex }}" @if($chunkIndex === 0) class="active" aria-current="true" @endif aria-label="Slide {{ $chunkIndex + 1 }}"></button>
                    @endforeach
                </div>

                <div class="carousel-inner">
                    @foreach($produits->chunk(4) as $chunkIndex => $chunk)
                        <div class="carousel-item @if($chunkIndex === 0) active @endif">
                            <div class="row justify-content-center">
                                @foreach($chunk as $produit)
                                    <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                                        <div class="card h-100 border-0 rounded-4 shadow-sm hover-scale transition-all overflow-hidden">
                                            <!-- Conteneur image avec effet zoom -->
                                            <div class="position-relative overflow-hidden image-zoom-container" style="height: 250px;">
                                                <img src="{{ $produit->getImageUrl() }}" 
                                                    alt="{{ $produit->name }}" 
                                                    class="img-fluid w-100 h-100 object-fit-cover zoom-image transition-all">
                                                
                                                <!-- Overlay interactif avec effet de fondu -->
                                                <div class="card-img-overlay d-flex flex-column justify-content-between align-items-center opacity-0 hover-opacity-100 bg-dark-50 transition-all p-3">
                                                    <!-- Badge catégorie -->
                                                    <div class="w-100 d-flex justify-content-end">
                                                        <span class="badge bg-primary rounded-pill px-3 py-2 shadow-sm">{{ $produit->categori->titre }}</span>
                                                    </div>
                                                    <!-- Bouton "Voir en détail" -->
                                                    <div class="w-100 d-grid">
                                                        <button class="btn btn-light rounded-pill shadow-sm">Voir en détail</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Corps de la carte -->
                                            <div class="card-body p-3">
                                                <h5 class="fw-bold text-truncate" title="{{ $produit->name }}">{{ $produit->name }}</h5>
                                                
                                                <!-- Prix et actions -->
                                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                                    <div>
                                                        <span class="badge bg-success fs-5 px-3 py-2"><strong>{{ $produit->prix_promo }} f cfa</strong></span>
                                                        <small class="text-muted ms-1"><strike>{{ $produit->getPrice() }}</strike></small>
                                                    </div>
                                                    <button class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm" wire:click="addToCart({{$produit->id}})">
                                                        <i class="fas fa-cart-plus me-2"></i> Ajouter
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Boutons de navigation customisés -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselProduits" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    <span class="visually-hidden">Précédent</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselProduits" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                    <span class="visually-hidden">Suivant</span>
                </button>

                <!-- Styles personnalisés pour un rendu ultra moderne -->
                <style>
                    .image-zoom-container {
                        transition: transform 0.4s ease;
                        overflow: hidden;
                        border-radius: 12px;
                    }

                    .zoom-image {
                        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
                    }

                    .image-zoom-container:hover .zoom-image {
                        transform: scale(1.1);
                    }

                    .hover-scale:hover {
                        transform: translateY(-5px);
                        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15)!important;
                    }

                    .card-img-overlay {
                        background: rgba(0, 0, 0, 0.4);
                        transition: opacity 0.3s ease-in-out;
                        border-radius: 12px;
                    }

                    .card:hover .card-img-overlay {
                        opacity: 1;
                    }

                    .hover-opacity-100 {
                        opacity: 0;
                    }

                    .card:hover .hover-opacity-100 {
                        opacity: 1;
                    }

                    .transition-all {
                        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    }

                    .bg-dark-50 {
                        background: rgba(0, 0, 0, 0.5);
                    }

                    /* Personnalisation des indicateurs du carousel */
                    .carousel-indicators [data-bs-target] {
                        width: 12px;
                        height: 12px;
                        border-radius: 50%;
                        background-color: #aaa;
                    }

                    .carousel-indicators .active {
                        background-color: #333;
                    }
                </style>
            </div>
        </div>
    </div>
</div>


