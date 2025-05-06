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
            <a href="{{ route('annonce.create') }}" wire:navigate>
                <button type="button" class="btn btn-primary" >
                    Nouvelle annonce
                </button>
            </a>
        </div>
        @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-valign-middle">
            <thead>
                <tr>
                    <th>titre</th>
                    <th>Status</th>
                    <th>image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($annonces as $annonce)
                    <tr>
                        <td>
                            {{$annonce->title}}
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
                                <img src="{{ asset('storage/images/annonces/'.$annonce->image)}}" alt="Product 1" class="img-fluid rounded" style="width: 40px; height: 40px;">
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger" wire:click="deleteannonce({{$annonce->id}})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>