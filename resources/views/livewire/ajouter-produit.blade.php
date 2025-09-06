<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-6">
            <!-- Messages de statut -->
            <div class="mb-4">
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

            <!-- Carte principale -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0"><i class="fas fa-box-open me-2"></i>Ajouter un produit</h3>
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="store">
                        <!-- Section Informations de base -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="titre" placeholder="Titre du produit">
                                    <label for="titre">Titre du produit</label>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select wire:model="categori_id" class="form-select @error('categori_id') is-invalid @enderror" 
                                            id="categori_id">
                                        <option selected>Choisir...</option>
                                        @foreach($categories as $categorie)
                                            <option value="{{ $categorie->id }}">{{ $categorie->titre }}</option>
                                        @endforeach
                                    </select>
                                    <label for="categori_id">Catégorie</label>
                                    @error('categori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section Prix -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input wire:model="prix_achat" type="number" step="0.01" 
                                           class="form-control @error('prix_achat') is-invalid @enderror" 
                                           id="prix_achat" placeholder="Prix d'achat">
                                    <label for="prix_achat">Prix d'achat</label>
                                    @error('prix_achat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input wire:model="price" type="number" step="0.01" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           id="price" placeholder="Prix catalogue">
                                    <label for="price">Prix catalogue</label>
                                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Autres Prix -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input wire:model="prix_technicien" type="number" step="0.01" 
                                           class="form-control @error('prix_technicien') is-invalid @enderror" 
                                           id="prix_technicien" placeholder="Prix technicien">
                                    <label for="prix_technicien">Prix technicien</label>
                                    @error('prix_technicien') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input wire:model="prix_minimum" type="number" step="0.01" 
                                           class="form-control @error('prix_minimum') is-invalid @enderror" 
                                           id="prix_minimum" placeholder="Prix minimum">
                                    <label for="prix_minimum">Prix minimum</label>
                                    @error('prix_minimum') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Stock et Fabricant -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input wire:model="stock" wire:change="afficher_compte" type="number" 
                                           class="form-control @error('stock') is-invalid @enderror" 
                                           id="stock" placeholder="Quantité" min="0">
                                    <label for="stock">Quantité en stock</label>
                                    @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input wire:model="fabricant" type="text" 
                                           class="form-control @error('fabricant') is-invalid @enderror" 
                                           id="fabricant" placeholder="Fabricant">
                                    <label for="fabricant">Fabricant</label>
                                    @error('fabricant') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Fournisseur -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select wire:model="fournisseur_id" class="form-select @error('fournisseur_id') is-invalid @enderror" 
                                            id="fournisseur_id">
                                        <option selected>Choisir...</option>
                                        @foreach($fournisseurs as $fournisseur)
                                            <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                                        @endforeach
                                    </select>
                                    <label for="fournisseur_id">Fournisseur</label>
                                    @error('fournisseur_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section Comptes - Affichée seulement si stock > 0 -->
                        @if($this->afficher_compte())
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Vous avez ajouté une quantité en stock ({{ $stock }} unités). 
                                Coût total : <strong>{{ number_format($prix_achat * $stock, 0, ',', ' ') }} FCFA</strong>.
                                Veuillez sélectionner le(s) compte(s) à débiter.
                            </div>
                        
                            <!-- Compte principal -->
                            <div class="mb-4">
                                <div class="form-floating">
                                    <select wire:model="compte_principal_id" wire:change="ajouter_compte" 
                                            class="form-select @error('compte_principal_id') is-invalid @enderror" 
                                            id="compte_principal_id" required>
                                        <option selected>Choisir le compte principal...</option>
                                        @foreach($comptes as $compte)
                                            <option value="{{ $compte->id }}">
                                                {{ $compte->nom }} 
                                                (Solde: {{ number_format($compte->montant, 0, ',', ' ') }} FCFA)
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="compte_principal_id">Compte principal</label>
                                    @error('compte_principal_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Si le compte principal n'a pas assez de fonds -->
                            @if($this->ajouter_compte())
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Le solde du compte principal est insuffisant. Veuillez répartir le montant entre deux comptes.
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input wire:model="montant_principal" type="number" 
                                                   class="form-control @error('montant_principal') is-invalid @enderror"
                                                   id="montant_principal" 
                                                   placeholder="Montant compte principal"
                                                   max="{{ $compte_principal_id ? $comptes->find($compte_principal_id)?->montant : 0 }}"
                                                   required>
                                            <label for="montant_principal">Montant du compte principal</label>
                                            @error('montant_principal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select wire:model="compte_secondaire_id" 
                                                    class="form-select @error('compte_secondaire_id') is-invalid @enderror" 
                                                    id="compte_secondaire_id" required>
                                                <option selected>Choisir le compte secondaire...</option>
                                                @foreach($comptes as $compte)
                                                    @if($compte->id != $compte_principal_id)
                                                        <option value="{{ $compte->id }}">
                                                            {{ $compte->nom }} 
                                                            (Solde: {{ number_format($compte->montant, 0, ',', ' ') }} FCFA)
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <label for="compte_secondaire_id">Compte secondaire</label>
                                            @error('compte_secondaire_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="form-floating">
                                        <input wire:model="montant_secondaire" type="number" 
                                               class="form-control @error('montant_secondaire') is-invalid @enderror"
                                               id="montant_secondaire" 
                                               placeholder="Montant compte secondaire"
                                               max="{{ $compte_secondaire_id ? $comptes->find($compte_secondaire_id)?->montant : 0 }}"
                                               required>
                                        <label for="montant_secondaire">Montant du compte secondaire</label>
                                        @error('montant_secondaire') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        @if($montant_principal && $montant_secondaire)
                                            <div class="form-text">
                                                Total réparti : {{ number_format($montant_principal + $montant_secondaire, 0, ',', ' ') }} FCFA
                                                @if(($montant_principal + $montant_secondaire) != ($prix_achat * $stock))
                                                    <span class="text-danger">
                                                        (Doit égaler {{ number_format($prix_achat * $stock, 0, ',', ' ') }} FCFA)
                                                    </span>
                                                @else
                                                    <span class="text-success">✓</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @elseif($stock == 0)
                            <div class="alert alert-secondary">
                                <i class="fas fa-info-circle me-2"></i>
                                Stock égal à 0 : le produit sera enregistré sans débiter de compte.
                            </div>
                        @endif
                        
                        <!-- Description -->
                        <div class="mb-4">
                            <div class="form-floating">
                                <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" 
                                          id="description" placeholder="Description" style="height: 100px"></textarea>
                                <label for="description">Description</label>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Upload d'image -->
                        <div class="mb-4">
                            <label class="form-label">Image du produit</label>
                            <div class="file-upload-input">
                                <input wire:model="image_produit" type="file" class="form-control" 
                                       id="inputGroupFile02" accept="image/*">
                                @error('image_produit') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                
                                @if ($image_produit)
                                    <div class="mt-3 text-center">
                                        <img src="{{ $image_produit->temporaryUrl() }}" 
                                             class="img-thumbnail preview-image" 
                                             alt="Prévisualisation"
                                             style="max-height: 200px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Enregistrer le produit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
.preview-image {
    max-height: 200px;
    object-fit: cover;
}

.alert {
    border-left: 4px solid;
}

.alert-info {
    border-left-color: #0dcaf0;
}

.alert-warning {
    border-left-color: #ffc107;
}

.alert-secondary {
    border-left-color: #6c757d;
}
</style>
</div>

