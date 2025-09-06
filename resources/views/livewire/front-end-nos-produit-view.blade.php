<div class="container py-0">
    <div class="text-center mb-4">
        <div class="row g-4 bg-grey align-items-center mb-0" data-aos="fade-up">
            <div class="col-lg-4 text-start">
                <h1 class="display-5 fw-bold gradient-text">
                    <a href="{{ route('all-produit') }}" style="text-decoration: none;">Nos Produits</a>
                </h1>
            </div>
            <div class="col-lg-8 text-end">
                <div class="magnetic-wrap">
                    <a href="{{ route('all-produit') }}" 
                       class="btn btn-dark rounded-pill magnetic-btn px-4 py-2 shadow-lg hover-lift">
                        <span class="hover-effect"></span>
                        Voir plus <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Utiliser wire:ignore pour empêcher Livewire de re-rendre cette section --}}
    <div wire:ignore>
        <div class="owl-carousel owl-theme" id="carouselProduits">
            @foreach($produits as $produit)
                <div class="item px-2">
                    <div class="card h-100 border-0 rounded-4 shadow-sm">
                        <a href="{{ route('produit-detail', $produit->id) }}" class="card-image-link d-block text-decoration-none position-relative">
                            @php
                                $image1 = public_path('images/produits/'. $produit->image_produit);
                                $image2 = public_path('storage/images/produits/'. $produit->image_produit);
                                $url = file_exists($image1) ? asset('images/produits/'. $produit->image_produit)
                                                           : asset('storage/images/produits/' . $produit->image_produit);
                            @endphp

                            <img src="{{ $url }}" class="card-img-top img-fluid" alt="{{ $produit->name }}" style="object-fit: cover; height: 250px;">
                        </a>

                        <div class="card-body p-3 text-center">
                            <h5 class="fw-bold">{{ $produit->name }}</h5>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="badge bg-success fs-6">{{ $produit->getPrice() }}</span>
                                {{-- Remplacer wire:click par onclick pour éviter le re-rendu --}}
                                <button onclick="addProduitToCart({{ $produit->id }})" class="btn btn-sm btn-primary rounded-pill px-3">
                                    <i class="fas fa-cart-plus me-1"></i> Ajouter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <script>
        let produitsCarouselInitialized = false;

        function initializeProduitsCarousel() {
            if (!produitsCarouselInitialized) {
                $('#carouselProduits').owlCarousel({
                    loop: true,
                    margin: 15,
                    nav: true,
                    dots: false,
                    autoplay: true,
                    autoplayTimeout: 1000,
                    autoplayHoverPause: true,
                    responsive:{
                        0:{ items:1 },
                        576:{ items:2 },
                        768:{ items:3 },
                        992:{ items:4 }
                    }
                });
                produitsCarouselInitialized = true;
            }
        }

        function addProduitToCart(productId) {
            // Appeler la méthode Livewire via JavaScript
            @this.call('addProductToCart', productId);
        }

        // Initialiser au chargement de la page
        $(document).ready(function(){
            initializeProduitsCarousel();
        });

        // Réinitialiser après les mises à jour Livewire (Livewire v2)
        document.addEventListener('livewire:load', function () {
            initializeProduitsCarousel();
        });

        // Pour Livewire v3 (si vous l'utilisez)
        document.addEventListener('livewire:navigated', function () {
            setTimeout(() => {
                initializeProduitsCarousel();
            }, 100);
        });

        // Écouter les événements de mise à jour du panier (optionnel)
        window.addEventListener('product-added-to-cart', function(event) {
            // Afficher une notification de succès
            console.log('Produit ajouté au panier:', event.detail.message);
            
            // Vous pouvez ajouter ici une notification toast, par exemple:
            toastr.success(event.detail.message);
            
            // Ou mettre à jour le compteur du panier dans l'interface
            updateCartCounter();
        });
    </script>
</div>