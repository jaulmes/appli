<div class="container py-5">
    <!-- En-tête -->
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h4 class="mb-0">Nos catégories de produit</h4>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('allPromoProduit') }}" class="btn btn-dark rounded-pill">
                Voir plus
            </a>
        </div>
    </div>

    <!-- Liste des catégories -->
    <div class="row g-3">
        @foreach($categoris as $categori)
        <div class="col-sm-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <!-- Image de la catégorie -->
                    <div class="me-3">
                        <img src="{{ asset('storage/images/produits/categories/' . $categori->image_categorie) }}" 
                             alt="Image de {{ $categori->titre }}" 
                             class="img-fluid rounded-circle" 
                             style="width: 80px; height: 80px; object-fit: cover;">
                    </div>
                    <!-- Contenu de la catégorie -->
                    <div>
                        <h5 class="card-title mb-2">
                            <a href="#" class="stretched-link text-decoration-none">{{ $categori->titre }}</a>
                        </h5>
                        <a href="#" class="btn btn-primary btn-sm">
                            Voir les produits
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
