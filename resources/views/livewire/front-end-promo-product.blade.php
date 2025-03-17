<div class="carousel slide row g-4 " data-bs-ride="carousel" data-bs-interval="4000">
    @foreach($produits->chunk(4) as $chunkIndex => $chunk)
        <div class="carousel-item @if($chunkIndex === 0) active @endif">
            <div class="row justify-content-center">
                @foreach($chunk as $produit)
                    <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                        <div class="card h-100 border-0 hover-scale overflow-hidden shadow-sm transition-all">
                            <!-- Conteneur image avec effet de zoom -->
                            <div class="position-relative overflow-hidden image-zoom-container" style="height: 250px;">
                                <img src="{{ $produit->getImageUrl() }}" 
                                     alt="{{ $produit->name }}" 
                                     class="img-fluid w-100 h-100 object-fit-cover transition-all zoom-image">
                                
                                <!-- Overlay interactif -->
                                <div class="card-img-overlay d-flex flex-column justify-content-between opacity-0 hover-opacity-100 bg-dark-20 transition-all">
                                    <div class="d-flex justify-content-end">
                                        
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-outline-light rounded-pill" >Voir en détail</button>
                                    </div>
                                </div>
                                
                                <!-- Badge catégorie -->
                                <div class="position-absolute top-0 start-0 m-3" style="color: white;">
                                    <span class="" >
                                        {{$produit->categori->titre}}
                                    </span>
                                </div>
                            </div>

                            <!-- Corps de la carte -->
                            <div class="card-body p-3">
                                <h5 class="fw-bold mb-2 text-truncate">{{$produit->name}}</h5>
                                
                                <!-- Prix et actions -->
                                <div class="d-flex align-items-center justify-content-between border-top pt-3">
                                    <div>
                                        <p>
                                            <span class="badge bg-success bolder" style="font-size: x-large;"><strong>{{$produit->prix_promo}}</strong></span>
                                            <small class="text-muted ms-1"><strike>{{$produit->getPrice()}}</strike></small>
                                        </p>
                                    </div>
                                </div>
                                <div class="btn-group align-items-center">
                                    <button class="btn btn-sm bg-primary btn-primary rounded-end-pill px-3">
                                        <i class="fas fa-cart-plus me-2"></i>Ajouter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
    <style>
    .image-zoom-container {
        transition: transform 0.3s;
        overflow: hidden;
    }
    
    .zoom-image {
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .image-zoom-container:hover .zoom-image {
        transform: scale(1.4);
    }
    
    .hover-scale:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08)!important;
    }
    
    .card-img-overlay {
        background: linear-gradient(180deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.1) 50%);
        z-index: 1;
    }
    
    .transition-all {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
</div>

