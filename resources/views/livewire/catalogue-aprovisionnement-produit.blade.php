<div class="container py-3">
    <div class="row">
        <!-- Catalogue de produits (75% de l'espace) -->
        <div class="col-md-9">
            <!-- Barre de recherche -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-20 col-10 row" style="position: fixed; z-index: 1; margin-left: 25em; margin-top: -3em;" >
                    <input class="form-control shadow-sm col" 
                           wire:model="query"
                           placeholder="🔍 Rechercher un produit 😀..."
                           wire:input="update_query"
                           type="search"
                           
                    >   
                    <div class="dropdown col">
                        <button class="btn btn-primary dropdown-toggle" type="button"  data-bs-toggle="dropdown" >

                                {{$categori}}

                            
                        </button>
                        <ul class="dropdown-menu" style="max-height: 300px; overflow-y: auto; " >
                            @foreach($categories as $categorie)
                                <li><a class="dropdown-item" wire:click="filtreProduit({{$categorie->id}})" >{{$categorie->titre}}</a></li>
                            @endforeach
                        </ul>
                    </div> 
                </div>
                
            </div>
            @if (session()->has('message'))
                <div class="row">
                    <span class="alert alert-success">
                        {{ session('message') }}
                    </span>
                </div>
            @endif
            <!-- Catalogue de produits -->
            <div class="row row-cols-1 row-cols-md-3 g-4">

                @forelse($produits as $produit)
                    <div class="col" wire:key="produit-{{ $produit->id }}">
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
                            @php
                                $image1 = public_path('images/produits/'. $produit->image_produit);
                                $image2 = public_path('storage/images/produits/'. $produit->image_produit);
                                $url = file_exists($image1)? asset('images/produits/'. $produit->image_produit)
                                                            : asset('storage/images/produits/' . $produit->image_produit);

                            @endphp

                            <img src="{{$url }}"
                                    class="card-img-top img-fluid"
                                    alt="{{ $produit->name }}"
                                    style="height: 150px; object-fit: cover;">

                            <!-- Infos produit -->
                            <div class="card-body row ">
                                <p class="card-title " title="{{ $produit->name }}">{{ $produit->name }}</p>
                                <p class="text-muted small">{{ $produit->getDescription() }}</p>
                                <p class="fw-bold text-primary">{{ $produit->prix_achat }} XAF</p>
                            </div>

                            <!-- Actions -->
                            <div class="card-footer bg-white border-0 text-center d-flex justify-content-around">
                                <a href="{{ route('produit.detail', $produit->id) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-eye"></i> Voir
                                </a>
                                <button class="btn btn-primary btn-sm" wire:click="addToCart('{{ $produit->id }}')">
                                    <i class="bi bi-cart-plus"></i> Ajouter
                                </button>                       
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card-body text-center">
                        <p class="fw-bold text-info">Auccun produit trouvé</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
