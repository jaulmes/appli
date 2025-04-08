<div>
    @if(count($cart) > 0)
        <ul class="list-group mb-3">
            @foreach($cart as $key => $item)
                <li class="list-group-item d-flex justify-content-between align-items-center" >
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/images/produits/' . $item['image']) }}" 
                             alt="Image de {{ $item['name'] }}" 
                             class="img-thumbnail me-2" 
                             style="width: 50px; height: 50px; object-fit: cover;">
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
                        <button wire:click="retirerProduit('{{ $key }}')" 
                                class="btn btn-sm btn-danger" 
                                aria-label="Retirer {{ $item['name'] }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </li>
            @endforeach 
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


    @else
        <p class="text-center">Votre panier est vide.</p>
    @endif
</div>
