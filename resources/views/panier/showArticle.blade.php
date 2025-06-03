@extends('dashboard.main')

@section('content')

<div class="container">
    <a href="{{ route('panier.index') }}"><button class="btn btn-primary">retour</button></a>
	<div class="">

	</div>
		<div class="card">
			<div class="container-fliud">
				<div class="wrapper row">

					<div class="preview col-md-6">
						                        @php
                            $image1 = public_path('images/produits/'. $produits->image_produit);
                            $url = file_exists($image1)? asset('images/produits/'. $produits->image_produit)
                                                        : asset('storage/images/produits/' . $produits->image_produit);
                        @endphp
                        <img src="{{$url }}"
                            style="height: 400px; width: 500px;"
                            >
						
					</div>
					<div class="details col-md-6">
						<h3 class="product-title">{{$produits->name}} <strong class="badge badge-pill badge-info">{{$stock}}</strong></h3>

						<p class="product-description">{!! str_replace(';', ';<br>', e($produits->description)) !!}</p>
						<h4 class="price">Prix: <span>{{$produits->getPrice()}}</span></h4>


					</div>
				</div>
			</div>
		</div>
	</div>

@endsection