<div >
    <div wire:ignore.self class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h2 class="modal-title h5 fw-bold text-primary">
                        <i class="fas fa-tag me-2"></i>Gestion des promotions
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                <div class="modal-body p-0">
                    <!-- Barre de recherche fixe -->
                    <div class="sticky-top bg-white pt-3 px-3 border-bottom">
                        <div class="input-group input-group-lg rounded-pill shadow-sm">
                            <span class="input-group-text bg-transparent border-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" 
                                    wire:model="query"
                                    wire:input="searchProduit()"
                                    class="form-control " 
                                    placeholder="Rechercher un produit..." 
                                    style="font-size: 0.9rem; 
                                            border-radius: 30px; 
                                            background-color: #f8f9fa;">
                        </div>
                    </div>

                    <!-- Tableau amélioré -->
                    <div class="table-responsive" style="max-height: 60vh">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="sticky-top bg-light">
                                <tr class="text-uppercase small text-muted">
                                    <th style="width: 30%">Produit</th>
                                    <th style="width: 12%">Prix Catalogue</th>
                                    <th style="width: 15%">Prix Promo</th>
                                    <th style="width: 14%">Pos. Promo</th>
                                    <th style="width: 14%">Pos. Catalogue</th>
                                    <th style="width: 15%">Activer</th>
                                </tr>
                            </thead>
                            
                            <tbody class="border-top-0">
                                @foreach($produit_non_promo as $produit)
                                <tr class="position-relative">
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-50px me-3">
                                                <img src="{{ $produit->getImageUrl() }}" 
                                                     class="rounded-3" 
                                                     alt="{{ $produit->name }}"
                                                     style="width: 40px; height: 40px; object-fit: cover">
                                            </div>
                                            <span class="fw-medium text-dark">{{ $produit->name }}</span>
                                        </div>
                                    </td>
                                    
                                    <td class="text-success fw-bold">{{ $produit->getPrice() }}</td>
                                    
                                    <td>
                                        @if($produit->prix_promo)
                                            <span class="badge bg-success">{{ $produit->prix_promo }} fcfa</span>
                                        @else
                                            <input type="number" 
                                                   class="form-control form-control-sm border-primary" 
                                                   placeholder="prix promo..."
                                                   wire:model="prix_promo.{{ $produit->id }}"
                                                   style="min-width: 100px">
                                        @endif
                                    </td>

                                    <td>
                                        <input type="number" 
                                               class="form-control form-control-sm text-center border-primary" 
                                               wire:model="position_promo.{{ $produit->id }}"
                                               value="{{ $produit->position_promo }}"
                                                placeholder="Pos promo"
                                               min="0">
                                    </td>
                                    
                                    <td>
                                        <input type="number" 
                                               class="form-control form-control-sm text-center border-primary" 
                                               wire:model="position_catalogue.{{ $produit->id }}"
                                               value="{{ $produit->position_catalogue }}"
                                               placeholder="Pos catalogue"
                                               min="0">
                                    </td>
                                    
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   role="switch"
                                                   wire:model="produit_selectionne"
                                                   value="{{ $produit->id }}"
                                                   style="transform: scale(1.3)">
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" 
                            class="btn btn-link text-muted" 
                            data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <button type="button" 
                            class="btn btn-primary px-4 rounded-pill fw-medium"
                            wire:click="submit()">
                        <i class="fas fa-check me-2"></i>Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>