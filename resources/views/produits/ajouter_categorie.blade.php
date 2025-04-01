@extends('dashboard.main')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <!-- Colonne centrée -->
            <div class="col-md-6">
                <div class="card card-secondary">
                    
                    @if(session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card-header">
                        <h3 class="card-title">Ajouter une catégorie</h3>
                    </div>

                    <form method="post" action="{{ route('produit.store_categori') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="titre" class="form-label">Titre</label>
                                <input type="text" name="titre" class="form-control" id="titre" placeholder="Entrer le titre de la catégorie" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="4" placeholder="Description"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="image_categorie" class="form-label">Image</label>
                                <input type="file" name="image_categorie" id="image_categorie" class="form-control">
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Soumettre</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
