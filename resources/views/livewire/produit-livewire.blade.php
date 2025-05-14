<div>
    <div class="card border-0 shadow-lg">
        <!-- En-tête de carte amélioré -->
        <div class="card-header bg-primary text-white d-flex flex-column flex-md-row justify-content-between align-items-center py-3">
            <h3 class="mb-0 d-flex align-items-center">
                <i class="fas fa-boxes me-3"></i>Gestion des Produits
            </h3>
            
            <div class="mt-3 mt-md-0 d-flex gap-2">
                <a href="{{route('produit.import')}}" class="btn btn-light">
                    <i class="fas fa-file-import me-2"></i>Importer
                </a>
            </div>
        </div>

        <!-- Alert Modernisé -->
        @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Barre de recherche améliorée -->
        <div class="card-body pt-4">
            <div class="row justify-content-between align-items-center mb-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <input class="form-control shadow-sm col"
                            wire:model="query"
                            wire:input="rechercher_produit"
                            placeholder="Rechercher un produit..."
                            type="search"
                        >
                        
                    </div>
                </div>
            </div>

            <!-- Tableau amélioré avec en-tête fixe -->
            <div class="table-responsive rounded-3" style="max-height: 600px; overflow-y: auto;">
                <table class="table table-hover align-middle">
                    <thead class="table-light" style="position: sticky; top: 0; z-index: 1; background: #f8f9fa;">
                        <tr>
                            <th class="ps-4">Produit</th>
                            <th>Catégorie</th>
                            <th class="text-center">Stock</th>
                            @can('IMPOT')
                                <th class="text-end">Achat</th>
                            @endcan
                                <th class="text-end">Vente</th>
                                <th class="text-end">Minimum</th>
                                <th class="text-end">Technicien</th>
                                <th class="d-none d-lg-table-cell">Description</th>
                                <th>Image</th>
                            @can('IMPOT')
                                <th class="text-center">Actions</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produits as $produit)
                            <tr class="cursor-pointer">
                                <!-- Colonne Produit -->
                                <td class="ps-4 fw-bold">{{$produit->name}}</td>
                                
                                <!-- Catégorie -->
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        {{$produit->categori->titre}}
                                    </span>
                                </td>
                                
                                <!-- Stock -->
                                <td class="text-center">
                                    <span class="badge rounded-pill 
                                        {{ $produit->stock > 5 ? 'bg-success' : 'bg-danger' }}">
                                        {{$produit->stock}}
                                    </span>
                                </td>
                                
                                <!-- Prix (Conditionnel) -->
                                @can('IMPOT')
                                <td class="text-end">
                                    {{ number_format($produit->prix_achat, 0, ',', ' ') }} FCFA
                                </td>
                                @endcan
                                
                                <!-- Prix de vente -->
                                <td class="text-end text-success fw-bold">
                                    {{ number_format($produit->price, 0, ',', ' ') }} FCFA
                                </td>
                                
                                <!-- Prix minimum -->
                                <td class="text-end">
                                    {{ number_format($produit->prix_minimum, 0, ',', ' ') }} FCFA
                                </td>
                                
                                <!-- Prix technicien -->
                                <td class="text-end">
                                    {{ number_format($produit->prix_technicien, 0, ',', ' ') }} FCFA
                                </td>
                                
                                <!-- Description -->
                                <td class="d-none d-lg-table-cell text-truncate" style="max-width: 200px;">
                                    {{$produit->description}}
                                </td>
                                
                                <!-- Image -->
                                <td>
                                    <div class="ratio ratio-1x1" style="width: 60px;">
                                        <img src="{{ asset('storage/images/produits/'.$produit->image_produit) }}" 
                                            class="img-thumbnail" 
                                            alt="{{ $produit->name }}"
                                            loading="lazy">
                                    </div>
                                </td>
                                
                                @can('IMPOT')
                                <!-- Actions -->
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('produit.show', $produit->id)}}" 
                                        class="btn btn-sm btn-primary"
                                        data-bs-toggle="tooltip"
                                        title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{route('produit.delete', $produit->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger"
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
                            <div class="card-body text-center">
                                <p class="fw-bold text-info">Auccun produit trouvé</p>
                            </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer ce produit ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Confirmer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>