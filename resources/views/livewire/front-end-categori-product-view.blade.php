<div class="container py-5">

    <div class="row g-4 bg-grey card-header mb-5">
        <div class="col-lg-4 text-start">
            <h4>Nos categories de produit</h4>
        </div>
        <div class="col-lg-8 text-end">
            <ul class="nav nav-pills d-inline-flex text-center">
                <li class="nav-item">
                    <button type="button" class="btn btn-dark rounded-pill" >
                        <span class="text-white" style="width: 130px;">
                            <a href="{{ route('allPromoProduit')}}" wire:navigate>Voir plus</a>
                        </span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <div class="row g-3 justify-content-center">
        @foreach($categoris as $categori)
            <div class="col-6 col-md-4 col-lg-3 col-xl-custom">
                <img src="{{ asset('frontend-assets/img/best-product-5.jpg')}}" class="img-fluid rounded-circle w-50" alt="Image">
            </div>
        @endforeach
    </div>
</div>