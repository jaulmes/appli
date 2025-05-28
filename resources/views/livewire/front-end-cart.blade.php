<div>
    <ul class="list-group mb-3">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <strong>Votre panier</strong>
            <span class="badge bg-primary rounded-pill">{{ count($cart) + count($panier_pack) }} article(s)</span>
        </li>
        @if(count($cart) > 0)
            @foreach($cart as $key => $item)
                <li class="list-group-item d-flex justify-content-between align-items-center" >
                    <div class="d-flex align-items-center">
                            @php
                                $image1 = public_path('images/produits/'. $item['image']);
                                $image2 = public_path('storage/images/produits/'. $item['image']);
                                $url = file_exists($image1)? asset('images/produits/'. $item['image'])
                                                            : asset('storage/images/produits/' . $item['image']);

                            @endphp

                            <img src="{{$url }}"
                                    class="card-img-top img-fluid"
                                    alt="{{ $item['name'] }}"
                                    style="object-fit: cover; width: 50px; height: 25px;">
                        <div>
                            <strong>{{ $item['name'] }}</strong><br>
                            @if($item['status_promo'] == 0)
                                <small class="text-muted">
                                    {{ $item['quantity'] }} x {{ number_format($item['price']) }}
                                </small>
                            @else
                                <small class="text-muted">
                                    {{ $item['quantity'] }} x {{ number_format($item['prix_promo']) }}
                                </small>
                            @endif
                        </div>
                    </div>
                    |<input type="number" min="1" placeholder="qte..." value="{{ $item['quantity'] }}" wire:model="quantities.{{ $key }}" wire:change=" modifier_quantite('{{ $key }}')" style="width: 3.5em;">|
                    <div>
                        <button wire:click="retirerProduit('{{ $key }}', 'produit')" 
                                class="btn btn-sm btn-danger" 
                                aria-label="Retirer {{ $item['name'] }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </li>
            @endforeach 
        @endif
        @if(count($panier_pack) > 0)
            @foreach($panier_pack as $key => $item)
                <li class="list-group-item d-flex justify-content-between align-items-center" >
                    <div class="d-flex align-items-center">
                        @php
                            $image1 = public_path('images/packs/'. $item['image']);
                            $url = file_exists($image1)? asset('images/packs/'. $item['image'])
                                                        : asset('storage/images/packs/' . $item['image']);
                        @endphp
                        <img src="{{$url }}"
                            alt="Image de {{ $item['titre'] }}" 
                            class="img-thumbnail me-2" 
                            style="width: 50px; height: 50px; object-fit: cover;"
                            >

                        <div>
                            <strong>{{ $item['titre'] }}</strong><br>
                            <small class="text-muted">
                                {{ $item['quantity'] }} x {{ number_format($item['prix']) }}
                            </small>
                        </div>
                    </div>
                    |<input type="number" min="1" placeholder="qte..." value="{{ $item['quantity'] }}" wire:model="quantities.{{ $key }}" wire:change=" modifier_quantite('{{ $key }}')" style="width: 3.5em;">|
                    <div>
                        <button wire:click="retirerProduit('{{ $key }}', 'pack')" 
                                class="btn btn-sm btn-danger" 
                                aria-label="Retirer {{ $item['titre'] }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
    <div class="fw-bold">
        Total : {{ number_format($montantTotal ?? 0) }} fcfa
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3 " >
        <button class="btn btn-danger" wire:click="vider_panier">
            <i class="bi bi-trash-fill me-1"></i> 🚮 Vider le panier
        </button>
        <a href=" {{ route('passer.commande')}}" wire:navigate class="btn btn-success">
            Passer la commande
        </a>
    </div>

</div>
