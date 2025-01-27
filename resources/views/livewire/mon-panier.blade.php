<div>
    <div class="row card shadow-2-strong mb-lg-0" id="monPanier" style="position: fixed; width: 25em; padding-bottom: 3em; padding-top: 3em; margin-top: -7em; margin-left: -20em; font-size:12px ">
        <h6><strong><u>Mon panier</u></strong></h6><br>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger fw-bolder">
                {{ session('error') }}
            </div>
        @endif
        <table class="table table-responsive" style="overflow-y: visible;">
            <thead>
                <tr>
                    <th scope="col" class="h6">Nom</th>
                    <th scope="col">P U</th>
                    <th scope="col">QTE</th>
                    <th scope="col">Prix T</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="card-body table-responsive p-0" style="height: 200px; font-size: xx-small;">
                @foreach( Cart::getContent() as $produit)
                <tr>
                    <th scope="row">
                        <p class="mb-2">{{ $produit->name }}</p>
                    </th>
                    <th class="align-middle">
                        <p class="mb-0" style="font-weight: 500;">
                            <select id="" wire:model="new_price" wire:change="update_prix('{{ $produit->id}}')">
                                <option value="{{ $produit->attributes['price'] }}" >{{ $produit->attributes['price'] }}</option>
                                <option value="{{ $produit->attributes['prix_minimum'] }}">{{ $produit->attributes['prix_minimum'] }}</option>
                                <option value="{{ $produit->attributes['prix_technicien'] }}">{{ $produit->attributes['prix_technicien'] }}</option>
                            </select>
                        </p>
                    </th>
                    <th class="align-middle row">
                        <span type="submit" wire:click="ajouterQuantite(' {{$produit->id}} ')">+</span>
                        <p class="mb-0" style="font-weight: 500;">{{ $produit->quantity }}</p>
                        <span type="submit" wire:click="diminuerQuantite(' {{$produit->id}} ')">-</span>
                    </th>
                    <th class="align-middle">
                        <p class="mb-0" style="font-weight: 500;">{{ $produit->price * $produit->quantity }}</p>
                    </th>
                    <th>
                        <form action="{{ route('produit.retirer', $produit->id) }}" method="get">
                            @csrf
                            <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="col-lg-4 col-xl-3">
            <div class="d-flex justify-content-between" style="font-weight: 500;">
                <p class="mb-2">total: </p>
                <p class="mb-2" style="margin-left: 10em;">{{ Cart::getTotal() }}</p>
            </div>
        </div>
        <form action="{{ url('detruire') }}" method="get">
            @csrf
            <button type="submit" class="btn btn-danger" style="width: 8em; font-size:10px">vider le panier</button>
        </form>
        <button type="button" style="width: 8em; margin-left:10em; margin-top:-4.7em; font-size:10px" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Valider la vente</button>
    </div>
</div>
