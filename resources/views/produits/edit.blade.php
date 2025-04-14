@extends('dashboard.main')

@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- Centrer le formulaire avec les classes Bootstrap -->
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Modifier le Produit</h3>
                    </div>
                    <div class="card-body">
                        <!-- Affichage des erreurs de validation -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="post" action="{{ route('produit.edit', $produit->id) }}" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row g-3">
                                <!-- Titre -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="titre" class="form-label">Titre</label>
                                        <input name="name" value="{{ old('name', $produit->name) }}" type="text" class="form-control @error('name') is-invalid @enderror" id="titre" placeholder="Entrer le titre">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Catégorie -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="categori_id" class="form-label">Catégorie</label>
                                        <select name="categori_id" required class="form-select @error('categori_id') is-invalid @enderror" id="categori_id">
                                            <option disabled {{ old('categori_id', $produit->categori_id) ? '' : 'selected' }}>Choisir la catégorie</option>
                                            @foreach($categories as $categorie)
                                                <option value="{{ $categorie->id }}"
                                                    {{ (old('categori_id', $produit->categori_id) == $categorie->id) ? 'selected' : '' }}>
                                                    {{ $categorie->titre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('categori_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Prix d'achat -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prix_achat" class="form-label">Prix d'achat</label>
                                        <input name="prix_achat" value="{{ old('prix_achat', $produit->prix_achat) }}" type="number" class="form-control @error('prix_achat') is-invalid @enderror" id="prix_achat" placeholder="Entrer le prix d'achat">
                                        @error('prix_achat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Prix de catalogue -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prix_vente" class="form-label">Prix de catalogue</label>
                                        <input name="price" value="{{ old('price', $produit->price) }}" type="number" class="form-control @error('price') is-invalid @enderror" id="prix_vente" placeholder="Entrer le prix de vente">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Prix technicien -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prix_technicien" class="form-label">Prix technicien</label>
                                        <input name="prix_technicien" value="{{ old('prix_technicien', $produit->prix_technicien) }}" type="number" class="form-control @error('prix_technicien') is-invalid @enderror" id="prix_technicien" placeholder="Entrer le prix technicien">
                                        @error('prix_technicien')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Prix minimum -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prix_minimum" class="form-label">Prix minimum</label>
                                        <input name="prix_minimum" value="{{ old('prix_minimum', $produit->prix_minimum) }}" type="number" class="form-control @error('prix_minimum') is-invalid @enderror" id="prix_minimum" placeholder="Entrer le prix minimum">
                                        @error('prix_minimum')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Stock -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stock" class="form-label">Stock</label>
                                        <input name="stock" value="{{ old('stock', $produit->stock) }}" type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" placeholder="Entrer le stock">
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Fabricant -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fabricant" class="form-label">Fabricant</label>
                                        <input type="text" name="fabricant" value="{{ old('fabricant', $produit->fabricant) }}" id="fabricant" class="form-control @error('fabricant') is-invalid @enderror" placeholder="Entrer le fabricant">
                                        @error('fabricant')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Entrer la description">{{ old('description', $produit->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Image -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="image_produit" class="form-label">Image</label>
                                        <input type="file" name="image_produit" class="form-control @error('image_produit') is-invalid @enderror" id="image_produit">
                                        @error('image_produit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if($produit->image_produit)
                                            <div class="mt-3">
                                                <label class="form-label">Image actuelle :</label><br>
                                                <img src="{{ asset('storage/images/produits/' . $produit->image_produit) }}" alt="Image du produit" class="img-fluid rounded" style="max-width: 150px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Bouton de soumission -->
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary px-4">Mettre à jour</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
