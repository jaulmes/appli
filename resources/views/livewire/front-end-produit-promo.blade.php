<div class="card card-outline card-primary">
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
        <ul class="products-list product-list-in-card pl-2 pr-2 mb-0">
            @forelse($produits as $produit)
                <li class="item d-flex align-items-center py-2">
                    <!-- Position d'affichage -->
                    <span class="badge badge-info mr-3" title="Position d'affichage">#{{ $produit->position_promo ?? '__' }}</span>

                    <!-- Image produit -->
                    <div class="product-img ">
                        @php
                            $image1 = public_path('images/produits/'. $produit->image_produit);
                            $image2 = public_path('storage/images/produits/'. $produit->image_produit);
                            $url = file_exists($image1)? asset('images/produits/'. $produit->image_produit)
                                                        : asset('storage/images/produits/' . $produit->image_produit);

                        @endphp

                        <img src="{{$url }}"
                                class="card-img-top img-fluid"
                                alt="{{ $produit->name }}"
                                style="height: 50px; object-fit: cover;">
                    </div>

                    <!-- Informations produit -->
                    <div class="product-info flex-grow-1">
                        <a href="javascript:void(0)" class="product-title text-dark font-weight-bold">
                            {{ $produit->name }}
                            <span class="badge badge-success float-right">{{ number_format($produit->prix_promo, 0, '', ' ') }} FCFA</span>
                        </a>
                        <p class="product-description text-muted mb-0 small">
                            {{ Str::limit($produit->getDescription(), 60) }}
                        </p>
                    </div>
                </li>
            @empty
                <li class="item text-center py-3">
                    <p class="text-muted mb-0">Aucun produit en promotion... <i class="bi bi-exclamation-circle"></i></p>
                </li>
            @endforelse
        </ul>
    </div>
    <!-- /.card-body -->

    <div class="card-footer text-center">
        <a href="{{ route('frontend.admin.allPromoProduit') }}" class="text-uppercase font-weight-bold">
            Voir tous les produits en promotion
        </a>
    </div>
    <!-- /.card-footer -->
</div>
