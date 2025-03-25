<div>
    <div class="card-header">
        <h3 class="card-title">Produits en promotion</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
        <ul class="products-list product-list-in-card pl-2 pr-2">
            @forelse($produits as $produit)
                <li class="item">
                    <div class="product-img">
                        <img src="{{ $produit->getImageUrl() }}" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                        <a href="javascript:void(0)" class="product-title">{{$produit->name}}
                        <span class="badge badge-warning float-right">$1800</span></a>
                        <span class="product-description">
                        {{$produit->getDescription()}}
                        </span>
                    </div>
                </li>
            @empty
                <li class="item cent">
                    <p> auccun produit en promotion ...<i class="bi bi-exclamation-circle "></i></p>
                </li> 
            @endforelse
            <!-- /.item -->
        </ul>
    </div>
        <!-- /.card-body -->
    <div class="card-footer text-center">
        <a href="{{ route('frontend.admin.allPromoProduit')}}" wire:navigate class="uppercase">Voir tous les produits en promotion</a>
    </div>
</div>
