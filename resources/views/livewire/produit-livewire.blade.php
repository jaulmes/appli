<div>
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <!-- En-tête moderne avec gradient -->
        <div class="card-header bg-gradient text-white py-4 px-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="d-flex align-items-center mb-3 mb-md-0">
                    <div class="icon-wrapper me-3">
                        <i class="fas fa-boxes fs-2"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold">Gestion des Produits</h3>
                        <small class="opacity-75">Gérez votre inventaire facilement</small>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <a href="{{route('produit.ajouter')}}" class="btn btn-light btn-lg shadow-sm hover-lift">
                        <i class="fas fa-plus-circle me-2"></i>Ajouter un produit
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <!-- Barre de recherche et filtres modernes -->
            <div class="row g-3 mb-4">
                <div class="col-md-8">
                    <div class="search-wrapper position-relative">
                        <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input class="form-control form-control-lg ps-5 shadow-sm border-0 bg-light"
                            wire:model="query"
                            wire:input="rechercher_produit"
                            placeholder="🔍 Rechercher par nom, catégorie..."
                            type="search"
                            style="border-radius: 15px;">
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select form-select-lg shadow-sm border-0 bg-light" style="border-radius: 15px;">
                        <option selected>Toutes les catégories</option>
                        <option>Électronique</option>
                        <option>Vêtements</option>
                        <option>Alimentaire</option>
                    </select>
                </div>
            </div>

            <!-- Statistiques rapides -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="stat-card p-3 rounded-3 bg-primary bg-opacity-10 border-start border-primary border-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Total Produits</p>
                                <h4 class="mb-0 fw-bold text-primary">{{ count($produits) }}</h4>
                            </div>
                            <i class="fas fa-cubes fs-2 text-primary opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card p-3 rounded-3 bg-success bg-opacity-10 border-start border-success border-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">En Stock</p>
                                <h4 class="mb-0 fw-bold text-success">
                                    {{ collect($produits)->where('stock', '>', 5)->count() }}
                                </h4>
                            </div>
                            <i class="fas fa-check-circle fs-2 text-success opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card p-3 rounded-3 bg-warning bg-opacity-10 border-start border-warning border-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Stock Faible</p>
                                <h4 class="mb-0 fw-bold text-warning">
                                    {{ collect($produits)->whereBetween('stock', [1, 5])->count() }}
                                </h4>
                            </div>
                            <i class="fas fa-exclamation-triangle fs-2 text-warning opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card p-3 rounded-3 bg-danger bg-opacity-10 border-start border-danger border-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Rupture</p>
                                <h4 class="mb-0 fw-bold text-danger">
                                    {{ collect($produits)->where('stock', '<=', 0)->count() }}
                                </h4>
                            </div>
                            <i class="fas fa-times-circle fs-2 text-danger opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau moderne avec design cards sur mobile -->
            <div class="table-responsive rounded-3 shadow-sm" style="max-height: 650px; overflow-y: auto;">
                <table class="table table-hover align-middle mb-0 modern-table">
                    <thead class="table-header-modern" style="position: sticky; top: 0; z-index: 10;">
                        <tr>
                            <th class="ps-4 border-0">
                                <div class="d-flex align-items-center">
                                    <input type="checkbox" class="form-check-input me-2">
                                    <span>Produit</span>
                                </div>
                            </th>
                            <th class="border-0">Catégorie</th>
                            <th class="text-center border-0">Stock</th>
                            @can('IMPOT')
                                <th class="text-end border-0">Prix Achat</th>
                            @endcan
                            <th class="text-end border-0">Prix Vente</th>
                            <th class="text-end border-0">Prix Min.</th>
                            <th class="text-end border-0">Prix Tech.</th>
                            <th class="border-0">Description</th>
                            <th class="border-0">Image</th>
                            @can('IMPOT')
                                <th class="text-center border-0">Actions</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produits as $produit)
                            <tr class="table-row-hover">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input me-3">
                                        <span class="fw-bold text-dark">{{$produit->name}}</span>
                                    </div>
                                </td>
                                
                                <td>
                                    <span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-weight: 500;">
                                        <i class="fas fa-tag me-1"></i>
                                        {{$produit->categori->titre ?? "Non défini"}}
                                    </span>
                                </td>
                                
                                <td class="text-center">
                                    <span class="badge rounded-pill px-3 py-2 fw-bold
                                        {{ $produit->stock > 5 ? 'bg-success' : ($produit->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                        <i class="fas fa-boxes me-1"></i>
                                        {{$produit->stock}}
                                    </span>
                                </td>
                                
                                @can('IMPOT')
                                <td class="text-end">
                                    <span class="text-muted fw-semibold">
                                        {{ number_format($produit->prix_achat, 0, ',', ' ') }} FCFA
                                    </span>
                                </td>
                                @endcan
                                
                                <td class="text-end">
                                    <span class="text-success fw-bold fs-6">
                                        <i class="fas fa-coins me-1"></i>
                                        {{ number_format($produit->price, 0, ',', ' ') }} FCFA
                                    </span>
                                </td>
                                
                                <td class="text-end">
                                    <span class="text-info fw-semibold">
                                        {{ number_format($produit->prix_minimum, 0, ',', ' ') }} FCFA
                                    </span>
                                </td>
                                
                                <td class="text-end">
                                    <span class="text-secondary fw-semibold">
                                        {{ number_format($produit->prix_technicien, 0, ',', ' ') }} FCFA
                                    </span>
                                </td>
                                
                                <td>
                                    <div class="description-cell" style="max-width: 200px;">
                                        <p class="mb-0 text-truncate text-muted small">
                                            {{$produit->description ?: "Aucune description"}}
                                        </p>
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="image-wrapper position-relative" style="width: 70px; height: 70px;">
                                        @php
                                            $legacyPath1 = public_path('images/produits/' . $produit->image_produit);
                                            $legacyPath2 = public_path('storage/images/produits/' . $produit->image_produit);
                                            $legacyUrl = null;

                                            if (!empty($produit->image_produit)) {
                                                if (file_exists($legacyPath1)) {
                                                    $legacyUrl = asset('images/produits/' . $produit->image_produit);
                                                } elseif (file_exists($legacyPath2)) {
                                                    $legacyUrl = asset('storage/images/produits/' . $produit->image_produit);
                                                }
                                            }

                                            $productImages = $produit->images ?? collect();
                                            $gifImage = $productImages->firstWhere('is_gif', true);

                                            if ($gifImage) {
                                                $displayImage = asset('images/produits/' . $gifImage->path);
                                            } elseif ($productImages->isNotEmpty()) {
                                                $displayImage = asset('images/produits/' . $productImages->first()->path);
                                            } else {
                                                $displayImage = $legacyUrl;
                                            }

                                            $displayImage = $displayImage ?? asset('images/default-product.png');
                                        @endphp

                                        <img src="{{ $displayImage }}" 
                                            class="img-fluid rounded-3 shadow-sm hover-zoom"
                                            alt="{{ $produit->name }}"
                                            loading="lazy"
                                            style="object-fit: cover; width: 100%; height: 100%;">
                                        
                                        @if($productImages->count() > 1)
                                            <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-dark">
                                                +{{ $productImages->count() - 1 }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                
                                @can('IMPOT')
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('produit.show', $produit->id)}}" 
                                            class="btn btn-sm btn-outline-primary rounded-start"
                                            data-bs-toggle="tooltip"
                                            title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{route('produit.delete', $produit->id)}}" method="post" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" 
                                                class="btn btn-sm btn-outline-danger rounded-end"
                                                data-bs-toggle="tooltip"
                                                title="Supprimer"
                                                onclick="return confirmDelete(event)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                @endcan
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-box-open fs-1 text-muted mb-3"></i>
                                        <p class="fw-bold text-muted fs-5">Aucun produit trouvé</p>
                                        <p class="text-muted">Commencez par ajouter votre premier produit</p>
                                        <a href="{{route('produit.ajouter')}}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus me-2"></i>Ajouter un produit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination moderne -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Affichage de <strong>1-{{ count($produits) }}</strong> sur <strong>{{ count($produits) }}</strong> produits
                </div>
                <nav>
                    <ul class="pagination mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Précédent</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Suivant</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal de suppression moderne -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 bg-danger bg-opacity-10">
                    <h5 class="modal-title text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Confirmation de suppression
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-trash-alt fs-1 text-danger mb-3"></i>
                    <p class="fs-5">Êtes-vous sûr de vouloir supprimer ce produit ?</p>
                    <p class="text-muted">Cette action est irréversible.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-check me-2"></i>Confirmer la suppression
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast moderne -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        @if (session()->has('message'))
            <div class="toast align-items-center border-0 show shadow-lg rounded-3" role="alert" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i> 
                        <strong>{{ session('message') }}</strong>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
    </div>

    <style>
        .table-header-modern {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-row-hover {
            transition: all 0.3s ease;
        }

        .table-row-hover:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .hover-zoom {
            transition: transform 0.3s ease;
        }

        .hover-zoom:hover {
            transform: scale(1.1);
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .search-wrapper input:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .empty-state {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .badge {
            transition: all 0.2s ease;
        }

        .badge:hover {
            transform: scale(1.05);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Activer les tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Activer les toasts
            const toastElList = [].slice.call(document.querySelectorAll('.toast'));
            toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl).show();
            });
        });

        function confirmDelete(event) {
            event.preventDefault();
            if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
                event.target.closest('form').submit();
            }
        }
    </script>
</div>