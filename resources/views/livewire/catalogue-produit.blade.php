<div class="container py-3">
    <div class="row">
        <!-- Catalogue de produits (75% de l'espace) -->
        <div class="col-md-9">
            <!-- Barre de recherche -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6 col-10">
                    <input class="form-control shadow-sm" 
                           wire:model="query"
                           placeholder="🔍 Rechercher un produit..."
                           wire:input="update_query"
                           type="search"
                    >    
                </div>
            </div>

            <!-- Catalogue de produits -->
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($produits as $produit)
                    <div class="col">
                        <div class="card h-100 shadow-sm border-1 rounded">
                            <!-- Badge de disponibilité -->
                            <div class="position-absolute top-0 start-0 m-2">
                                @if($produit->getAlert())
                                    <span class="badge bg-danger">{{ $produit->getAlert() }}</span>
                                @endif
                                @if($produit->getStock() === "disponible")
                                    <span class="badge bg-success">Disponible</span>
                                @else
                                    <span class="badge bg-danger">Indisponible</span>
                                @endif
                            </div>

                            <!-- Image produit -->
                            <img src="{{ asset('storage/images/produits/'.$produit->image_produit) }}" 
                                 class="card-img-top img-fluid" 
                                 alt="{{ $produit->name }}" 
                                 style="height: 150px; object-fit: cover;">

                            <!-- Infos produit -->
                            <div class="card-body text-center">
                                <h6 class="card-title text-truncate" title="{{ $produit->name }}">{{ $produit->name }}</h6>
                                <p class="text-muted small">{{ $produit->getDescription() }}</p>
                                <p class="fw-bold text-primary">{{ $produit->getPrice() }} XAF</p>
                            </div>

                            <!-- Actions -->
                            <div class="card-footer bg-white border-0 text-center d-flex justify-content-around">
                                <a href="{{ route('produit.detail', $produit->id) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-eye"></i> Voir
                                </a>
                                @if($produit->getStock() === "disponible")
                                    <button class="btn btn-primary btn-sm" wire:click="ajouterPanier('{{ $produit->id }}')">
                                        <i class="bi bi-cart-plus"></i> Ajouter
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
