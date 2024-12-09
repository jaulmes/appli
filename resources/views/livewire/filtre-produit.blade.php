<div class="row row-cols-1 row-cols-md-3 g-3 mr-0">
    @foreach($produits as $produit)
        <div class="col mb-3 " style="margin-right: -4em;">
            <div class="card h-100" style="width: 12em; " >
                <strong class="badge badge-danger">{{ $produit->getAlert() }}</strong>
                @if($produit->getStock() === "disponible")
                <strong class="badge badge-info">{{ $produit->getStock() }}</strong>
                @elseif($produit->getStock() === "indisponible")
                <strong class="badge badge-danger">{{ $produit->getStock() }}</strong>
                @endif
                <img src="{{ asset('storage/images/produits/'.$produit->image_produit) }}" class="img-fluid" alt="" style="height: 5em; width: 100%;">
                <div class="member-info" style="font-size: 12px;">
                    <h7><u>Nom</u>: {{ $produit->name }}</h7>
                    <p class="card-text"><u>Desc</u>: {{ $produit->getDescription() }}</p>
                    <p class="card-text"><u>Prix</u>: <strong class="text-success">{{ $produit->getPrice() }}</strong></p>
                    <div class="row" style="margin-left: 0.2em; padding-bottom: 0.01em; margin-top: 0.5em;">
                        <a href="{{ route('produit.detail', $produit->id) }}">
                            <button class="btn btn-warning px-1"><i class="bi bi-eye"></i></button>
                        </a>
                        @if($produit->getStock() === "disponible")
                        <form action="{{ route('panier.ajouter') }}" method="post">
                            @csrf
                            <div class="action">
                                <input type="hidden" name="id" value="{{ $produit->id }}">
                                <input type="hidden" name="name" value="{{ $produit->name }}">
                                <input type="hidden" name="price" value="{{ $produit->price }}">
                                <button class="add-to-cart btn btn-primary px-1" type="submit" style="margin-left: 4em; margin-top:-3.5em"><i class="bi bi-plus"></i></button>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
