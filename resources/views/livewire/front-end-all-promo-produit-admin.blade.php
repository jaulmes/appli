<div class="card">
    <div class="card-header border-0 ">
        <h3 class="message">
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </h3>
        <h3 class="card-title ">Tous les produits en promotion</h3>
        <div class="card-tools">
            <div>
                <!-- Button trigger modal -->
                <button type="button" class="badge bg-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                ajouter un produit
                </button>

                <!-- Modal -->
                <livewire:front-end-modal-all-product>
            </div>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Prix </th>
                    <th>Prix promo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produit_promo as $produit)
                    <tr :produit="$produit" :key="$produit->id">
                        <td>
                        {{ $produit->position_promo.'/'.$produit_promo->count() ?? '#_' }}
                            <img src="{{ $produit->getImageUrl() }} " alt="Product 1" class="img-circle img-size-32 mr-2">
                            {{$produit->name}}
                        </td>
                        <td>{{$produit->price}}</td>
                        <td>
                            {{$produit->prix_promo}}
                        </td>
                        <td>
                            <span class="text-muted badge bg-danger" wire:click="annulerPromo({{$produit->id}})" type="button" title="Annuler la promo">
                                annuler la promo
                            </span>

                            <!-- Button trigger modal -->
                            <span type="button" class="badge bg-primary" title="Modifier" 
                                        data-bs-toggle="modal" data-bs-target="#modifier-{{ $produit->id }}"
                                         data-bs-target="#modifier">
                                ✏️
                            </span>

                            <!-- Modal -->
                            <livewire:front-end-modal-modifier-detail-promo :produit="$produit" :key="$produit->id"/>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>
                            <p> auccun produit en promotion ...<i class="bi bi-exclamation-circle "></i></p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>