<div class="position-relative">
    <!-- Champ de recherche -->
    <div class="row">
        <input 
            type="text" 
            wire:model.debounce.100ms="query" 
            class="form-control col rounded-pill shadow-sm " 
            placeholder="Rechercher un produit, un service…"
            wire:input="rechercher"
        >
        @if($query)
            <button class="btn btn-danger" wire:click="annuler()" style="width: 2em;">X</button>
        @endif 
    </div>

    <!-- Résultats -->
    @if(!empty($results))
        <ul class="list-group position-absolute w-100 shadow-sm mt-1" style="z-index: 1000; max-height: 300px; overflow-y: auto; font-size: small;">
            @foreach($results as $type => $items)
                @if(count($items))
                    <!-- Titre de la catégorie -->
                    <li class="list-group-item active fw-bold">{{ $type }}</li>

                    <!-- Liste des résultats -->
                    @foreach($items as $item)
                        <li class="list-group-item">
                            @if($type == 'Produits')
                                <a href=" {{ route('produit-detail', $item->id) }}" role="button" style="color: grey;">
                                    {{ $item->name }}
                                    @if($item->status_promo == 1)
                                        <span class="badge bg-success ms-2" >{{ number_format($item->prix_promo, 0, ".", " ") }}</span>
                                    @else
                                        <span class="badge bg-success ms-2">{{ number_format($item->price, 0, ".", " ") }}</span>
                                    @endif
                                </a>
                            @elseif($type == 'Services')
                                <a href="{{ route('detail-service', $item->id) }}" style="color: grey;">
                                    {{ $item->name }}
                                </a>
                            @elseif($type == 'Réalisations')
                                <a href="{{ route('detail-realisation', $item->id) }}" style="color: grey;">
                                    {{ $item->titre }}
                                </a>
                            @elseif($type == 'Catégories')
                                <a href="{{ route('categorie-detail', $item->id) }}" style="color: grey;">
                                    {{ $item->titre }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach
        </ul>
    @elseif(strlen($query) > 2)
        <ul class="list-group position-absolute w-100 shadow-sm mt-1" style="z-index: 1000;">
            <li class="list-group-item text-muted">Aucun résultat trouvé.</li>
        </ul>
    @endif
</div>