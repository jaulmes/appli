<div class="container py-3">
    <div class="row">
        <!-- Catalogue de packs (75% de l'espace) -->
        <div class="col-md-9">
            <!-- Barre de recherche -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-20 col-10 row w-50" style=" position:fixed; top: 10%; z-index: 1000; left:20%;  padding: 20px; " >
                    <input class="form-control shadow-sm col" 
                           wire:model="query"
                           placeholder="🔍 Rechercher un pack..."
                           wire:input="update_query"
                           type="search"
                    >   
                </div>
                
            </div>

            <!-- Catalogue de packs -->
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @forelse($packs as $pack)
                    <div class="col" wire:key="pack-{{ $pack->id }}">
                        <div class="card h-100 shadow-sm border-1 rounded">

                            <!-- Image pack -->
                            <img src="{{ asset('storage/images/packs/'.$pack->image) }}" 
                                 class="card-img-top img-fluid" 
                                 alt="{{ $pack->name }}" 
                                 style="height: 150px; object-fit: cover;">

                            <!-- Infos pack -->
                            <div class="card-body row ">
                                <p class="card-title " title="{{ $pack->name }}">{{ $pack->titre }}</p>
                                <p class="text-muted small">{{ $pack->description }}</p>
                                <p class="fw-bold text-primary">{{ $pack->prix }} XAF</p>
                            </div>

                            <!-- Actions -->
                            <div class="card-footer bg-white border-0 text-center d-flex justify-content-around">
                                <!-- Button trigger modal -->
                                <span type="button" class="btn btn-secondary mr-3" style="font-size: xx-small;" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{$pack->id}}">
                                    <i class="bi bi-eye"></i>
                                    Voir
                                </span>

                                <!-- Modal -->
                                <div class="modal fade"  id="staticBackdrop-{{$pack->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <livewire:pack-detail :pack="$pack" />
                                        </div>
                                    </div>
                                </div>
                                <span class="btn btn-primary btn-sm" wire:click="addToCart({{ $pack->id }})">
                                    <i class="bi bi-cart-plus"></i> Ajouter
                                </span>                       
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card-body text-center">
                        <p class="fw-bold text-info">Auccun pack trouvé</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
