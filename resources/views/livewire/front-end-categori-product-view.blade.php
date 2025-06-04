<div class="container py-5">
    <!-- En-tête -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h4 class="mb-0 fw-bold">Nos catégories de produit</h4>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('all-categorie') }}" wire:navigate class="btn btn-dark rounded-pill">
                Tous voir
            </a>
        </div>
    </div>

    <!-- Vérification s'il y a des catégories -->
    @if($categoris->isEmpty())
        <div class="alert alert-warning text-center">
            Aucune catégorie disponible pour le moment.
        </div>
    @else
        <!-- Liste des catégories -->
        <div class="row g-4">
            @foreach($categoris as $categori)
            <div class="col-sm-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 hover-shadow">
                    <div class="card-body d-flex align-items-center">
                        <!-- Image de la catégorie -->
                        <div class="me-3">
                            @php
                                $image1 = public_path('images/produits/categories/'. $categori->image_categorie);
                                $url = file_exists($image1)? asset('images/produits/categories/'. $categori->image_categorie)
                                                            : asset('storage/images/produits/categories/' . $categori->image_categorie);
                            @endphp
                            <img src="{{ $url}}" 
                                alt="Image de {{ $categori->titre }}" 
                                class="img-fluid rounded-circle border" 
                                style="width: 80px; height: 80px; object-fit: cover;" 
                                loading="lazy">
                        </div>
                        <!-- Contenu de la catégorie -->
                        <div>
                            <h5 class="card-title mb-2">
                                <a href="{{ route('categorie-detail', $categori->id) }}" 
                                   wire:navigate class="stretched-link text-dark text-decoration-none fw-semibold">
                                    {{ $categori->titre }}
                                </a>
                            </h5>
                            <a href="{{ route('categorie-detail', $categori->id) }}" 
                               wire:navigate class="btn btn-primary btn-sm">
                                Voir les produits
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
    <style>
    /* Effet au survol pour améliorer l'expérience utilisateur */
    .hover-shadow:hover {
        transform: translateY(-3px);
        transition: all 0.3s ease-in-out;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15) !important;
    }
</style>
</div>


