@extends('dashboard.main')

@section('content')
<section class="content">
    <div class="container-fluid ml-md-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-primary">
                    @if(Session::has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-header text-center">
                        <h3 class="card-title">Modifier la catégorie</h3>
                    </div>

                    <form method="post" action="{{ route('produit.edit_categori', $categories->id) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="titre">Titre</label>
                                <input name="titre" value="{{ old('titre', $categories->titre) }}" type="text" class="form-control @error('name') is-invalid @enderror" id="titre" placeholder="Entrer le titre">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Description...">{{ old('description', $categories->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="image_categorie" id="image_categorie" class="form-control">
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <a href=" {{ route('produit.categori')}}" class="btn btn-danger">Retour</a>
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
