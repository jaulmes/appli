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
                                        <option selected >Choisir...</option>
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
                                    <label for="prix_achat">Prix d'achat </label>
                                    @error('prix_achat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input wire:model="price" type="number" step="0.01" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           id="price" placeholder="Prix catalogue">
                                    <label for="price">Prix catalogue </label>
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
                                    <label for="prix_technicien">Prix technicien </label>
                                    @error('prix_technicien') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input wire:model="prix_minimum" type="number" step="0.01" 
                                           class="form-control @error('prix_minimum') is-invalid @enderror" 
                                           id="prix_minimum" placeholder="Prix minimum">
                                    <label for="prix_minimum">Prix minimum </label>
                                    @error('prix_minimum') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Stock et Fabricant -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input wire:model="stock" type="number" 
                                           class="form-control @error('stock') is-invalid @enderror" 
                                           id="stock" placeholder="Quantité">
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

                        <!-- Fournisseur et Compte -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select wire:model="fournisseur_id" class="form-select @error('fournisseur_id') is-invalid @enderror" 
                                            id="fournisseur_id">
                                        <option selected >Choisir...</option>
                                        @foreach($fournisseurs as $fournisseur)
                                            <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                                        @endforeach
                                    </select>
                                    <label for="fournisseur_id">Fournisseur</label>
                                    @error('fournisseur_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 row" >
                            <div class="form-floating col">
                                <select wire:model="compte_principal_id" wire:change="ajouter_compte" class="form-select @error('compte_id') is-invalid @enderror" 
                                        id="compte_id">
                                    <option selected >Choisir...</option>
                                    @foreach($comptes as $compte)
                                        <option value="{{ $compte->id }}">{{ $compte->nom }} (solde: {{$compte->montant}} XAF)</option>
                                    @endforeach
                                </select>
                                <label for="compte_id">Compte</label>
                                @error('compte_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <!-- Montant à débiter dans ce compte -->
                            @if($this->ajouter_compte() == true)
                                <input type="number"
                                        class="form-control col"
                                        wire:model="montant_principal"
                                        placeholder="Montant à prélever">
                            @endif
                        </div>
                        <div class="row mb-3">
                            @if($this->ajouter_compte() == true)
                                <div class="text-red ">le solde du compte est insufisant, veuillez choisir un deuxiemme supperieur au montant pour completer</div>
                                <select wire:model="compte_secondaire_id" class="form-select col @error('compte_id2') is-invalid @enderror" 
                                        >
                                    <option selected >Choisir...</option>
                                    @foreach($comptes as $compte)
                                        <option value="{{ $compte->id }}">{{ $compte->nom }} (solde: {{$compte->montant}} XAF)</option>
                                    @endforeach
                                </select><br>
                                <input type="number"
                                    wire:model="montant_secondaire"
                                    class="form-control col"
                                    placeholder="Montant à prélever">
                            @endif                              
                        </div>
                        
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
                                             alt="Prévisualisation">
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
</div>