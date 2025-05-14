<div class="position-relative">
    <!-- Desktop Version -->
    <div class="row d-none d-lg-flex">
        <div class="position-relative col">
            <input 
                type="text" 
                wire:model.debounce.100ms="query" 
                class="form-control rounded-pill shadow-sm" 
                placeholder="Rechercher un produit, un service…"
                wire:input="rechercher"
            >
            @if($query)
                <button class="btn btn-danger position-absolute end-0 top-50 translate-middle-y me-3" 
                        wire:click="annuler()" 
                        style="height: 24px; width: 24px; padding: 0; border-radius: 50%;">
                    X
                </button>
            @endif
        </div>
    </div>

    <!-- Mobile Version -->
    <div class="d-lg-none">
        <!-- Fixed Search Container -->
        <div class="fixed-top  pt-1 pb-1 " 
                style="z-index: 1000; padding-left: 0rem; padding-right: 0rem; margin-left: 6em;
                        width: 60%; text-decoration: none; border-radius: 50px; margin-top: 1rem;">
            <div class="position-relative">
                <input 
                    type="text" 
                    wire:model.debounce.100ms="query" 
                    class="form-control rounded-pill shadow-sm" 
                    placeholder="Rechercher…"
                    wire:input="rechercher"
                >
                @if($query)
                    <button class="btn btn-danger position-absolute end-0 top-50 translate-middle-y me-3" 
                            wire:click="annuler()" 
                            style="height: 24px; width: 24px; padding: 0; border-radius: 50%;">
                        X
                    </button>
                @endif
            </div>
        </div>

        <!-- Results Container -->
        @if(!empty($results))
            <div class="fixed-top mt-5 pt-2" style="z-index: 999; height: calc(100vh - 70px); overflow-y: auto;">
                <ul class="list-group shadow-sm" style="font-size: small; margin-left: 1rem; margin-right: 1rem;">
                    @foreach($results as $type => $items)
                        @if(count($items))
                            <li class="list-group-item active fw-bold">{{ $type }}</li>
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
            </div>
        @elseif(empty($results) && $query > 2)
            <div class="fixed-top mt-5 pt-2" style="z-index: 999; margin-left: 1rem; margin-right: 1rem;">
                <div class="list-group shadow-sm">
                    <div class="list-group-item text-muted">Aucun résultat trouvé...</div>
                </div>
            </div>
        @endif
    </div>

    <!-- Desktop Results (keep existing) -->
    @if(!empty($results))
        <ul class="list-group d-none d-lg-block position-absolute w-100 shadow-sm mt-1" 
            style="z-index: 1000; max-height: 300px; overflow-y: auto; font-size: small;">
            @foreach($results as $type => $items)
                @if(count($items))
                    <li class="list-group-item active fw-bold">{{ $type }}</li>
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
    @elseif(empty($results) && $query > 2)
        <div class="fixed-top mt-5 pt-2" style="z-index: 999; margin-left: 1rem; margin-right: 1rem;">
            <div class="list-group shadow-sm">
                <div class="list-group-item text-muted">Aucun résultat trouvé...</div>
            </div>
        </div>
    @endif
</div>