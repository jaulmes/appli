<div class="container py-5">
    <!-- En-tête -->
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h4 class="mb-0">Nos catégories de produits</h4>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('allPromoProduit') }}" class="btn btn-dark rounded-pill">
                Voir plus
            </a>
        </div>
    </div>

    <!-- Liste des catégories -->
    <div class="row g-3">
        @forelse($categoris as $categori)
            <div class="col-sm-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex align-items-center">
                        <!-- Image de la catégorie -->
                        <div class="me-3">
                            <img src="{{ $categori->image_categorie ? asset('storage/images/produits/categories/' . $categori->image_categorie) : asset('images/default-category.jpg') }}" 
                                 alt="Image de {{ $categori->titre }}" 
                                 class="img-fluid rounded-circle border" 
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                        <!-- Contenu de la catégorie -->
                        <div>
                            <h5 class="card-title mb-2">
                                <a href="{{ route('produits.parCategorie', $categori->id) }}" 
                                   class="stretched-link text-decoration-none text-dark fw-bold">
                                    {{ $categori->titre }}
                                </a>
                            </h5>
                            <a href="{{ route('produits.parCategorie', $categori->id) }}" 
                               class="btn btn-primary btn-sm">
                                Voir les produits
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Aucune catégorie disponible pour le moment.</p>
            </div>
        @endforelse
    </div>
</div>
