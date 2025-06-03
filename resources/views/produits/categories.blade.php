@extends('dashboard.main')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Liste des catégories</h3>
        <a href="{{ route('produit.ajouter_categori') }}" class="btn btn-primary">Ajouter une catégorie</a>
    </div>

    <div class="card-body">
        <table id="categoriesTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $categorie)
                <tr>
                    <td>{{ $categorie->titre }}</td>
                    <td>{{ $categorie->description }}</td>
                    <td>
                        <!-- Image categorie -->
                        @php
                            $image1 = public_path('images/produits/categories/'. $categorie->image_categorie);
                            $url = file_exists($image1)? asset('images/produits/categories/'. $categorie->image_categorie)
                                                        : asset('storage/images/produits/categories/' . $categorie->image_categorie);
                        @endphp
                        <img src="{{$url }}"
                            style="max-width: 100px;"
                            >
                    </td>
                    <td>
                        @can('IMPOT')
                            <a href="{{ route('produit.show_categori', $categorie->id) }}" class="btn btn-warning btn-sm">
                                Modifier
                            </a>
                            <form action="{{ route('produit.delete_categories', $categorie->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                    Supprimer
                                </button>
                            </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#categoriesTable').DataTable({
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true
        });
    });
</script>
@endsection
