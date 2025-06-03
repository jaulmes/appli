<div>
    <!-- bootstrap-select CSS -->
<link 
  rel="stylesheet" 
  href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0/dist/css/bootstrap-select.min.css">

<!-- jQuery (nécessaire pour bootstrap-select) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- bootstrap-select JS -->
<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0/dist/js/bootstrap-select.min.js">
</script>
    <div class="card-header border-0">
        <h3 class="card-title text-center">annonce</h3>
        <div class="card-tools">
            <a href="{{ route('annonce.create') }}" >
                <button type="button" class="btn btn-primary" >
                    Nouvelle annonce
                </button>
            </a>
        </div>
        @if (session()->has('annonce_sucess'))
        <div class="alert alert-success">
            {{ session('annonce_sucess') }}
        </div>
        @endif
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-valign-middle">
            <thead>
                <tr>
                    <th>Produit/service</th>
                    <th>Status</th>
                    <th>image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($annonces as $annonce)
                    <tr>
                        <td>
                            {{$annonce->produits->name?? $annonce->services->name}}
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                @if($annonce->status == 'actif')
                                    <input class="form-check-input" wire:click="changeStatus({{$annonce->id}})" checked type="checkbox" role="switch" id="flexSwitchCheckDefault" >
                                @else
                                    <input class="form-check-input" wire:click="changeStatus({{$annonce->id}})" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="mb-3">
                            @php
                                $image1 = public_path('images/annonces/'. $annonce->image);
                                $image2 = public_path('storage/images/annonces/'. $annonce->image);
                                $url = file_exists($image1)? asset('images/annonces/'. $annonce->image)
                                                            : asset('storage/images/annonces/' . $annonce->image);
                            @endphp

                            <img src="{{$url }}"
                                    class="card-img-top img-fluid "
                                    alt="{{ $annonce->name }}"
                                    style="object-fit: cover; height: 50px; width: 50px;">
                            </div>
                        </td>
                        <td>
                            <!-- Modal modifier annonce-->
                            <div  class="modal fade" id="editAnnonce-{{$annonce->id}}" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <livewire:front-end-edit-annonce-admin :annonce="$annonce" />
                            </div>
                            <i class="bi bi-pencil-square text-blue"  type="button" data-bs-toggle="modal" data-bs-target="#editAnnonce-{{$annonce->id}}" ></i>
                            <i class="fas fa-trash text-red" wire:click="deleteAnnonce({{$annonce->id}})" type="button"></i>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>