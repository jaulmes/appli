<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Détail du pack</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                @php
                    $image1 = public_path('images/packs/'. $pack->image);
                    $url = file_exists($image1)? asset('images/packs/'. $pack->image)
                                                : asset('storage/images/packs/' . $pack->image);
                @endphp
                <img src="{{$url }}"
                    alt="Image de la réalisation"
                    class="d-block w-100 object-fit-cover zoom-image"
                    style="height: 200px;"
                    >
                <p class="text-muted small">{{ $pack->description }}</p>
            </div>
            <div class="col-md-6">
                <h5 class="card-title">{{ $pack->titre }}</h5>
                <p class="fw-bold text-primary">{{ $pack->prix }} XAF</p>
                <p class="text-muted small">Nombre de produits: {{ $pack->produits->count() }}</p>
                <div class="produits">
                    <h6>Produits inclus:</h6>
                    <ul class="list-group">
                        @foreach($pack->produits as $produit)
                            <li class="list-group-item">
                                <span class="badge bg-primary float-start">{{ $produit->pivot->quantity }}</span>
                                <strong>{{ $produit->name }}</strong> -  ({{ $produit->pivot->price }} XAF) en Stock <span class="text-small @if ($produit->stock < 5) badge bg-danger @else  bg-primary @endif"> {{ $produit->stock }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="button" class="btn btn-primary" wire:click="addToCart('{{ $pack->id }}')">
            <i class="bi bi-cart-plus"></i> Ajouter au panier
        </button>
    </div>
</div>