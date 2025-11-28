<div >
    <div wire:ignore.self class="modal fade" id="gererAffichargeProduits" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h2 class="modal-title h5 fw-bold text-primary">
                        <i class="fas fa-tag me-2"></i>Gestion de l'afficharge des produits sur le site web
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
                                    <th style="width: 12%">visibilite sur le site</th>
                                </tr>
                            </thead>
                            
                            <tbody class="border-top-0">
                                @foreach($produits as $produit)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/images/produits/' . $produit->image_produit) }}" alt="{{ $produit->nom_produit }}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <div class="fw-bold">{{ $produit->name }}</div>
                                                    <div class="text-muted small">{{ $produit->fabricant }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" 
                                                       wire:change="toggleVisibility({{ $produit->id }})" 
                                                       {{ $produit->is_website_visible ? 'checked' : '' }}>
                                                <label class="form-check-label">
                                                    {{ $produit->is_website_visible ? 'Visible' : 'Masqué' }}
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- messages de confirmation avec croix pour fermer le message -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show position-fixed bottom-0 end-0 m-3" role="alert" style="z-index: 1055;">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>