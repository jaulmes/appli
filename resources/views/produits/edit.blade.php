@extends('dashboard.main')

@section('content')
<section class="content py-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <!-- En-tête -->
                <div class="mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('produit.index') }}">Produits</a></li>
                            <li class="breadcrumb-item active">Modifier le produit</li>
                        </ol>
                    </nav>
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper me-3 p-3 rounded-circle" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="fas fa-edit fs-4 text-white"></i>
                        </div>
                        <div>
                            <h2 class="mb-1 fw-bold">Modifier le Produit</h2>
                            <p class="text-muted mb-0">Mettez à jour les informations de votre produit</p>
                        </div>
                    </div>
                </div>

                <!-- Messages -->
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('message'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Carte principale -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-box me-2"></i>
                                {{ $produit->name }}
                            </h4>
                            <span class="badge bg-white text-primary px-3 py-2">
                                <i class="fas fa-barcode me-1"></i>
                                ID: #{{ $produit->id }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-exclamation-circle fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="alert-heading mb-2">Erreurs de validation</h5>
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="post" action="{{ route('produit.edit', $produit->id) }}" enctype="multipart/form-data" id="productEditForm">
                            @method('put')
                            @csrf

                            <!-- Informations générales -->
                            <div class="section-card mb-4">
                                <div class="section-header mb-3">
                                    <h5 class="mb-0 fw-bold text-primary">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Informations Générales
                                    </h5>
                                    <hr class="mt-2">
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input name="name" value="{{ old('name', $produit->name) }}" 
                                                   type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" placeholder="Nom du produit" required>
                                            <label><i class="fas fa-tag me-2 text-primary"></i>Nom du produit *</label>
                                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select name="categori_id" required class="form-select @error('categori_id') is-invalid @enderror">
                                                <option disabled>Choisir la catégorie</option>
                                                @foreach($categories as $categorie)
                                                    <option value="{{ $categorie->id }}" 
                                                        {{ old('categori_id', $produit->categori_id) == $categorie->id ? 'selected' : '' }}>
                                                        {{ $categorie->titre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label><i class="fas fa-list me-2 text-primary"></i>Catégorie *</label>
                                            @error('categori_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="fabricant" value="{{ old('fabricant', $produit->fabricant) }}" 
                                                   class="form-control @error('fabricant') is-invalid @enderror" placeholder="Fabricant">
                                            <label><i class="fas fa-industry me-2 text-primary"></i>Fabricant</label>
                                            @error('fabricant')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input name="stock" value="{{ old('stock', $produit->stock) }}" 
                                                   type="number" class="form-control @error('stock') is-invalid @enderror" 
                                                   id="stock" placeholder="Stock" required min="0" onchange="checkStockChange()">
                                            <label><i class="fas fa-boxes me-2 text-primary"></i>Stock disponible *</label>
                                            @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            <small class="text-muted">Stock actuel: 
                                                <span class="badge {{ $produit->stock > 5 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $produit->stock }}
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select name="fournisseur_id" class="form-select @error('fournisseur_id') is-invalid @enderror">
                                                <option value="">Sélectionner un fournisseur</option>
                                                @foreach($fournisseurs as $fournisseur)
                                                    <option value="{{ $fournisseur->id }}" 
                                                        {{ old('fournisseur_id', $produit->fournisseurs->first()?->id) == $fournisseur->id ? 'selected' : '' }}>
                                                        {{ $fournisseur->nom }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label><i class="fas fa-truck me-2 text-primary"></i>Fournisseur</label>
                                            @error('fournisseur_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                                      style="height: 100px" placeholder="Description">{{ old('description', $produit->description) }}</textarea>
                                            <label><i class="fas fa-align-left me-2 text-primary"></i>Description</label>
                                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tarification -->
                            <div class="section-card mb-4">
                                <div class="section-header mb-3">
                                    <h5 class="mb-0 fw-bold text-success">
                                        <i class="fas fa-money-bill-wave me-2"></i>Tarification
                                    </h5>
                                    <hr class="mt-2">
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="price-card p-3 rounded-3 border border-info bg-info bg-opacity-10">
                                            <label class="form-label fw-bold text-white mb-2">
                                                <i class="fas fa-shopping-cart me-2"></i>Prix d'achat *
                                            </label>
                                            <div class="input-group input-group-lg">
                                                <input name="prix_achat" value="{{ old('prix_achat', $produit->prix_achat) }}" 
                                                       type="number" class="form-control @error('prix_achat') is-invalid @enderror" 
                                                       id="prix_achat" required min="0" onchange="calculateMargins()">
                                                <span class="input-group-text fw-bold">FCFA</span>
                                                @error('prix_achat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="price-card p-3 rounded-3 border border-success bg-success bg-opacity-10">
                                            <label class="form-label fw-bold text-white mb-2">
                                                <i class="fas fa-tag me-2"></i>Prix de catalogue *
                                            </label>
                                            <div class="input-group input-group-lg">
                                                <input name="price" value="{{ old('price', $produit->price) }}" 
                                                       type="number" class="form-control @error('price') is-invalid @enderror" 
                                                       required min="0" onchange="calculateMargins()">
                                                <span class="input-group-text fw-bold">FCFA</span>
                                                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="price-card p-3 rounded-3 border border-warning bg-warning bg-opacity-10">
                                            <label class="form-label fw-bold text-white mb-2">
                                                <i class="fas fa-tools me-2"></i>Prix technicien *
                                            </label>
                                            <div class="input-group input-group-lg">
                                                <input name="prix_technicien" value="{{ old('prix_technicien', $produit->prix_technicien) }}" 
                                                       type="number" class="form-control @error('prix_technicien') is-invalid @enderror" 
                                                       required min="0" onchange="calculateMargins()">
                                                <span class="input-group-text fw-bold">FCFA</span>
                                                @error('prix_technicien')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="price-card p-3 rounded-3 border border-danger bg-danger bg-opacity-10">
                                            <label class="form-label fw-bold text-white mb-2">
                                                <i class="fas fa-percentage me-2"></i>Prix minimum *
                                            </label>
                                            <div class="input-group input-group-lg">
                                                <input name="prix_minimum" value="{{ old('prix_minimum', $produit->prix_minimum) }}" 
                                                       type="number" class="form-control @error('prix_minimum') is-invalid @enderror" 
                                                       required min="0" onchange="calculateMargins()">
                                                <span class="input-group-text fw-bold">FCFA</span>
                                                @error('prix_minimum')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Aperçu des marges -->
                                <div class="alert alert-light border mt-3" id="margins-preview">
                                    <div class="row text-center">
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Marge catalogue</small>
                                            <strong class="text-success fs-5" id="marge-catalogue">
                                                {{ number_format(($produit->price - $produit->prix_achat), 0, ',', ' ') }} FCFA
                                            </strong>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Marge technicien</small>
                                            <strong class="text-warning fs-5" id="marge-technicien">
                                                {{ number_format(($produit->prix_technicien - $produit->prix_achat), 0, ',', ' ') }} FCFA
                                            </strong>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Marge minimum</small>
                                            <strong class="text-danger fs-5" id="marge-minimum">
                                                {{ number_format(($produit->prix_minimum - $produit->prix_achat), 0, ',', ' ') }} FCFA
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section Comptes (affichée si le stock augmente) -->
                            <div id="comptes-section" style="display: none;">
                                <div class="section-card mb-4">
                                    <div class="section-header mb-3">
                                        <h5 class="mb-0 fw-bold text-warning">
                                            <i class="fas fa-wallet me-2"></i>
                                            Gestion des Comptes
                                        </h5>
                                        <hr class="mt-2">
                                    </div>

                                    <div class="alert alert-info" id="stock-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <span id="stock-message"></span>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <select name="compte_principal_id" id="compte_principal_id" 
                                                        class="form-select @error('compte_principal_id') is-invalid @enderror" 
                                                        onchange="checkAccountBalance()">
                                                    <option value="">Choisir le compte principal...</option>
                                                    @foreach($comptes as $compte)
                                                        <option value="{{ $compte->id }}" data-solde="{{ $compte->montant }}">
                                                            {{ $compte->nom }} (Solde: {{ number_format($compte->montant, 0, ',', ' ') }} FCFA)
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label><i class="fas fa-university me-2"></i>Compte principal</label>
                                                @error('compte_principal_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section compte secondaire -->
                                    <div id="second-account-section" style="display: none;" class="mt-3">
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            Le solde du compte principal est insuffisant. Veuillez répartir le montant.
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input name="montant_principal" id="montant_principal" type="number" 
                                                           class="form-control @error('montant_principal') is-invalid @enderror" 
                                                           placeholder="Montant" min="0" onchange="checkTotalAmount()">
                                                    <label>Montant du compte principal</label>
                                                    @error('montant_principal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select name="compte_secondaire_id" id="compte_secondaire_id" 
                                                            class="form-select @error('compte_secondaire_id') is-invalid @enderror">
                                                        <option value="">Choisir le compte secondaire...</option>
                                                        @foreach($comptes as $compte)
                                                            <option value="{{ $compte->id }}" data-solde="{{ $compte->montant }}">
                                                                {{ $compte->nom }} (Solde: {{ number_format($compte->montant, 0, ',', ' ') }} FCFA)
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <label>Compte secondaire</label>
                                                    @error('compte_secondaire_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <input name="montant_secondaire" id="montant_secondaire" type="number" 
                                                           class="form-control @error('montant_secondaire') is-invalid @enderror" 
                                                           placeholder="Montant" min="0" onchange="checkTotalAmount()">
                                                    <label>Montant du compte secondaire</label>
                                                    @error('montant_secondaire')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                    <div id="total-check" class="form-text"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section Images avec suppression -->
                            <div class="section-card mb-4">
                                <div class="section-header mb-3">
                                    <h5 class="mb-0 fw-bold text-danger">
                                        <i class="fas fa-images me-2"></i>
                                        Images du Produit
                                    </h5>
                                    <hr class="mt-2">
                                </div>

                                <div class="alert alert-info border-0 d-flex align-items-start">
                                    <i class="fas fa-info-circle fs-4 me-3 mt-1"></i>
                                    <div>
                                        <strong>Information importante :</strong>
                                        <p class="mb-0">Vous pouvez supprimer des images individuellement ou ajouter de nouvelles images qui s'ajouteront aux images existantes.</p>
                                    </div>
                                </div>

                                <!-- Zone de téléversement -->
                                <div class="upload-zone mb-4 p-4 border-2 border-dashed rounded-3 text-center" style="border-color: #dee2e6;">
                                    <i class="fas fa-cloud-upload-alt fs-1 text-primary mb-3"></i>
                                    <h6 class="fw-bold mb-2">Glissez vos images ici ou cliquez pour parcourir</h6>
                                    <p class="text-muted small mb-3">Formats: JPG, PNG, GIF (Max 2MB/image)</p>
                                    <input type="file" name="images[]" id="image_produit" 
                                           class="form-control @error('images') is-invalid @enderror" 
                                           multiple accept="image/*" onchange="previewImages(event)">
                                    @error('images')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>

                                <!-- Prévisualisation des nouvelles images -->
                                <div id="new-images-preview" class="mb-4" style="display: none;">
                                    <h6 class="fw-semibold mb-3">
                                        <span class="badge bg-success me-2">Nouvelles images sélectionnées</span>
                                    </h6>
                                    <div id="preview-container" class="row g-3"></div>
                                </div>

                                <!-- Anciennes images (logique unique) -->
                                @if($produit->image_produit)
                                    <div class="images-section mb-4" id="old-single-image">
                                        <div class="d-flex align-items-center mb-3">
                                            <span class="badge bg-secondary me-2">Ancienne logique</span>
                                            <h6 class="mb-0 text-muted">Image unique</h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                @php
                                                    $oldPath1 = public_path('storage/images/produits/' . $produit->image_produit);
                                                    $oldPath2 = public_path('images/produits/' . $produit->image_produit);
                                                    $oldImageUrl = file_exists($oldPath1)
                                                        ? asset('storage/images/produits/' . $produit->image_produit)
                                                        : asset('images/produits/' . $produit->image_produit);
                                                @endphp
                                                <div class="image-card position-relative" data-image-type="old-single">
                                                    <img src="{{ $oldImageUrl }}" alt="Ancienne image"
                                                         class="img-fluid rounded-3 shadow-sm border"
                                                         style="object-fit: cover; aspect-ratio: 1/1;">
                                                    <button type="button" class="btn-delete-image" onclick="deleteOldSingleImage()">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <div class="overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 rounded-3 d-flex align-items-center justify-content-center opacity-0 transition">
                                                        <i class="fas fa-search-plus text-white fs-3"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Champ caché pour marquer la suppression -->
                                        <input type="hidden" name="delete_old_single_image" id="delete_old_single_image" value="0">
                                    </div>
                                @endif

                                <!-- Nouvelles images (logique multiple) -->
                                @if($produit->images && $produit->images->count() > 0)
                                    <div class="images-section">
                                        <div class="d-flex align-items-center mb-3">
                                            <span class="badge bg-primary me-2">Nouvelle logique</span>
                                            <h6 class="mb-0">Images actuelles (<span id="images-count">{{ $produit->images->count() }}</span>)</h6>
                                        </div>
                                        <div class="row g-3" id="existing-images-container">
                                            @foreach($produit->images as $image)
                                                @php
                                                    $imageUrl = asset('images/produits/' . $image->path);
                                                @endphp
                                                <div class="col-md-3 col-sm-4 col-6" id="image-{{ $image->id }}">
                                                    <div class="image-card position-relative">
                                                        <img src="{{ $imageUrl }}" alt="Image produit"
                                                             class="img-fluid rounded-3 shadow-sm border"
                                                             style="object-fit: cover; aspect-ratio: 1/1;">
                                                        @if(Str::endsWith(strtolower($image->path), '.gif'))
                                                            <span class="position-absolute top-0 start-0 m-2 badge bg-warning">
                                                                <i class="fas fa-film me-1"></i>GIF
                                                            </span>
                                                        @endif
                                                        <button type="button" class="btn-delete-image" onclick="deleteExistingImage({{ $image->id }})">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        <div class="overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 rounded-3 d-flex align-items-center justify-content-center opacity-0 transition">
                                                            <i class="fas fa-search-plus text-white fs-3"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <!-- Champ caché pour stocker les IDs des images à supprimer -->
                                        <input type="hidden" name="deleted_images" id="deleted_images" value="">
                                    </div>
                                @endif

                                @if(!$produit->image_produit && (!$produit->images || $produit->images->count() == 0))
                                    <div class="text-center py-5" id="no-images-message">
                                        <i class="fas fa-image fs-1 text-muted mb-3"></i>
                                        <p class="text-muted">Aucune image disponible pour ce produit</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <a href="{{ route('produit.index') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-lg text-white px-5 shadow-sm hover-lift" 
                                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <i class="fas fa-save me-2"></i>Mettre à jour le produit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .section-card {
        transition: all 0.3s ease;
    }

    .price-card {
        transition: all 0.3s ease;
    }

    .price-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .upload-zone {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .upload-zone:hover {
        background-color: #f8f9fa;
        border-color: #667eea !important;
    }

    .image-card {
        overflow: hidden;
        border-radius: 0.75rem;
    }

    .image-card .overlay {
        transition: opacity 0.3s ease;
    }

    .image-card:hover .overlay {
        opacity: 1 !important;
    }

    /* Style pour le bouton de suppression */
    .btn-delete-image {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #dc3545;
        border: 2px solid white;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 10;
        padding: 0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }

    .btn-delete-image:hover {
        background-color: #c82333;
        transform: scale(1.1);
    }

    .image-card:hover .btn-delete-image {
        opacity: 1;
    }

    .btn-delete-image i {
        font-size: 14px;
    }

    /* Animation de suppression */
    @keyframes fadeOutScale {
        0% {
            opacity: 1;
            transform: scale(1);
        }
        100% {
            opacity: 0;
            transform: scale(0.8);
        }
    }

    .image-deleting {
        animation: fadeOutScale 0.3s ease forwards;
    }

    .hover-lift {
        transition: all 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3) !important;
    }

    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-select:focus ~ label {
        color: #667eea;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        font-size: 1.2rem;
    }

    .breadcrumb-item a {
        color: #667eea;
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        color: #764ba2;
        text-decoration: underline;
    }
</style>

<script>
    const initialStock = {{ $produit->stock }};
    const initialPrixAchat = {{ $produit->prix_achat }};
    let deletedImagesIds = [];

    // Supprimer l'ancienne image unique
    function deleteOldSingleImage() {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
            document.getElementById('delete_old_single_image').value = '1';
            const imageSection = document.getElementById('old-single-image');
            imageSection.querySelector('.image-card').classList.add('image-deleting');
            
            setTimeout(() => {
                imageSection.style.display = 'none';
                showNoImagesMessageIfNeeded();
            }, 300);
        }
    }

    // Supprimer une image existante (nouvelle logique)
    function deleteExistingImage(imageId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
            deletedImagesIds.push(imageId);
            document.getElementById('deleted_images').value = deletedImagesIds.join(',');
            
            const imageElement = document.getElementById('image-' + imageId);
            imageElement.querySelector('.image-card').classList.add('image-deleting');
            
            setTimeout(() => {
                imageElement.remove();
                updateImagesCount();
                showNoImagesMessageIfNeeded();
            }, 300);
        }
    }

    // Mettre à jour le compteur d'images
    function updateImagesCount() {
        const container = document.getElementById('existing-images-container');
        if (container) {
            const count = container.querySelectorAll('[id^="image-"]').length;
            const countElement = document.getElementById('images-count');
            if (countElement) {
                countElement.textContent = count;
            }
        }
    }

    // Afficher le message "Aucune image" si nécessaire
    function showNoImagesMessageIfNeeded() {
        const oldSingleImage = document.getElementById('old-single-image');
        const existingImages = document.getElementById('existing-images-container');
        const newImagesPreview = document.getElementById('new-images-preview');
        
        const hasOldImage = oldSingleImage && oldSingleImage.style.display !== 'none';
        const hasExistingImages = existingImages && existingImages.querySelectorAll('[id^="image-"]').length > 0;
        const hasNewImages = newImagesPreview && newImagesPreview.style.display !== 'none';
        
        let noImagesMessage = document.getElementById('no-images-message');
        
        if (!hasOldImage && !hasExistingImages && !hasNewImages) {
            if (!noImagesMessage) {
                noImagesMessage = document.createElement('div');
                noImagesMessage.id = 'no-images-message';
                noImagesMessage.className = 'text-center py-5';
                noImagesMessage.innerHTML = `
                    <i class="fas fa-image fs-1 text-muted mb-3"></i>
                    <p class="text-muted">Aucune image disponible pour ce produit</p>
                `;
                document.querySelector('.section-card .section-header').parentElement.appendChild(noImagesMessage);
            }
            noImagesMessage.style.display = 'block';
        } else if (noImagesMessage) {
            noImagesMessage.style.display = 'none';
        }
    }

    // Vérifier si le stock augmente
    function checkStockChange() {
        const newStock = parseInt(document.getElementById('stock').value) || 0;
        const prixAchat = parseInt(document.getElementById('prix_achat').value) || 0;
        const comptesSection = document.getElementById('comptes-section');
        const stockMessage = document.getElementById('stock-message');
        
        if (newStock > initialStock) {
            const diffStock = newStock - initialStock;
            const coutAjout = diffStock * prixAchat;
            
            comptesSection.style.display = 'block';
            stockMessage.innerHTML = `Vous augmentez le stock de <strong>${diffStock}</strong> unités. 
                Coût supplémentaire : <strong>${coutAjout.toLocaleString('fr-FR')} FCFA</strong>. 
                Veuillez sélectionner le(s) compte(s) à débiter.`;
        } else {
            comptesSection.style.display = 'none';
        }
    }

    // Vérifier le solde du compte principal
    function checkAccountBalance() {
        const comptePrincipalSelect = document.getElementById('compte_principal_id');
        const selectedOption = comptePrincipalSelect.options[comptePrincipalSelect.selectedIndex];
        const solde = parseFloat(selectedOption.getAttribute('data-solde')) || 0;
        
        const newStock = parseInt(document.getElementById('stock').value) || 0;
        const prixAchat = parseInt(document.getElementById('prix_achat').value) || 0;
        const diffStock = Math.max(0, newStock - initialStock);
        const coutAjout = diffStock * prixAchat;
        
        const secondAccountSection = document.getElementById('second-account-section');
        
        if (coutAjout > solde) {
            secondAccountSection.style.display = 'block';
            document.getElementById('montant_principal').max = solde;
            
            document.getElementById('montant_principal').value = solde;
            document.getElementById('montant_secondaire').value = coutAjout - solde;
        } else {
            secondAccountSection.style.display = 'none';
        }
    }

    // Vérifier que le total correspond au coût
    function checkTotalAmount() {
        const montantPrincipal = parseFloat(document.getElementById('montant_principal').value) || 0;
        const montantSecondaire = parseFloat(document.getElementById('montant_secondaire').value) || 0;
        const totalCheck = document.getElementById('total-check');
        
        const newStock = parseInt(document.getElementById('stock').value) || 0;
        const prixAchat = parseInt(document.getElementById('prix_achat').value) || 0;
        const diffStock = Math.max(0, newStock - initialStock);
        const coutAjout = diffStock * prixAchat;
        
        const total = montantPrincipal + montantSecondaire;
        
        if (total === coutAjout) {
            totalCheck.innerHTML = `<span class="text-success">✓ Total correct : ${total.toLocaleString('fr-FR')} FCFA</span>`;
        } else {
            totalCheck.innerHTML = `<span class="text-danger">Le total (${total.toLocaleString('fr-FR')} FCFA) doit égaler ${coutAjout.toLocaleString('fr-FR')} FCFA</span>`;
        }
    }

    // Calculer les marges en temps réel
    function calculateMargins() {
        const prixAchat = parseFloat(document.querySelector('[name="prix_achat"]').value) || 0;
        const priceCatalogue = parseFloat(document.querySelector('[name="price"]').value) || 0;
        const prixTechnicien = parseFloat(document.querySelector('[name="prix_technicien"]').value) || 0;
        const prixMinimum = parseFloat(document.querySelector('[name="prix_minimum"]').value) || 0;
        
        const margeCatalogue = priceCatalogue - prixAchat;
        const margeTechnicien = prixTechnicien - prixAchat;
        const margeMinimum = prixMinimum - prixAchat;
        
        document.getElementById('marge-catalogue').textContent = margeCatalogue.toLocaleString('fr-FR') + ' FCFA';
        document.getElementById('marge-technicien').textContent = margeTechnicien.toLocaleString('fr-FR') + ' FCFA';
        document.getElementById('marge-minimum').textContent = margeMinimum.toLocaleString('fr-FR') + ' FCFA';
        
        document.getElementById('marge-catalogue').className = margeCatalogue >= 0 ? 'text-success fs-5' : 'text-danger fs-5';
        document.getElementById('marge-technicien').className = margeTechnicien >= 0 ? 'text-warning fs-5' : 'text-danger fs-5';
        document.getElementById('marge-minimum').className = margeMinimum >= 0 ? 'text-danger fs-5' : 'text-danger fs-5';
    }

    // Prévisualisation des images
    function previewImages(event) {
        const files = event.target.files;
        const previewSection = document.getElementById('new-images-preview');
        const previewContainer = document.getElementById('preview-container');
        
        if (files.length > 0) {
            previewSection.style.display = 'block';
            previewContainer.innerHTML = '';
            
            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 col-sm-4 col-6';
                    
                    const isGif = file.name.toLowerCase().endsWith('.gif');
                    
                    col.innerHTML = `
                        <div class="image-card position-relative">
                            <img src="${e.target.result}" 
                                 class="img-fluid rounded-3 shadow-sm border"
                                 style="object-fit: cover; aspect-ratio: 1/1;">
                            ${isGif ? '<span class="position-absolute top-0 start-0 m-2 badge bg-warning"><i class="fas fa-film me-1"></i>GIF</span>' : ''}
                            <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white text-center py-2 small">
                                ${file.name}
                            </div>
                        </div>
                    `;
                    
                    previewContainer.appendChild(col);
                };
                
                reader.readAsDataURL(file);
            });
            
            // Masquer le message "Aucune image"
            const noImagesMessage = document.getElementById('no-images-message');
            if (noImagesMessage) {
                noImagesMessage.style.display = 'none';
            }
            
            // Message de confirmation
            const uploadZone = document.querySelector('.upload-zone');
            let confirmMsg = uploadZone.parentElement.querySelector('.alert-success');
            
            if (!confirmMsg) {
                confirmMsg = document.createElement('div');
                confirmMsg.className = 'alert alert-success mt-3 alert-dismissible fade show';
                uploadZone.parentElement.insertBefore(confirmMsg, uploadZone.nextSibling);
            }
            
            confirmMsg.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                <strong>${files.length} image(s) sélectionnée(s) - Ces images s'ajouteront aux images existantes</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
        } else {
            previewSection.style.display = 'none';
            showNoImagesMessageIfNeeded();
        }
    }

    // Animation au chargement
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });

        document.querySelectorAll('.section-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.5s ease';
            observer.observe(card);
        });

        checkStockChange();
    });

    // Validation avant soumission
    document.getElementById('productEditForm').addEventListener('submit', function(e) {
        const newStock = parseInt(document.getElementById('stock').value) || 0;
        
        if (newStock > initialStock) {
            const comptePrincipal = document.getElementById('compte_principal_id').value;
            
            if (!comptePrincipal) {
                e.preventDefault();
                alert('Veuillez sélectionner un compte principal pour l\'augmentation de stock.');
                return false;
            }
            
            const secondAccountVisible = document.getElementById('second-account-section').style.display !== 'none';
            
            if (secondAccountVisible) {
                const montantPrincipal = parseFloat(document.getElementById('montant_principal').value) || 0;
                const montantSecondaire = parseFloat(document.getElementById('montant_secondaire').value) || 0;
                const compteSecondaire = document.getElementById('compte_secondaire_id').value;
                
                const prixAchat = parseInt(document.getElementById('prix_achat').value) || 0;
                const diffStock = newStock - initialStock;
                const coutAjout = diffStock * prixAchat;
                
                if (!compteSecondaire) {
                    e.preventDefault();
                    alert('Veuillez sélectionner un compte secondaire.');
                    return false;
                }
                
                if (montantPrincipal + montantSecondaire !== coutAjout) {
                    e.preventDefault();
                    alert(`La somme des montants (${montantPrincipal + montantSecondaire} FCFA) doit égaler le coût total (${coutAjout} FCFA).`);
                    return false;
                }
            }
        }
        
        return true;
    });
</script>
@endsection