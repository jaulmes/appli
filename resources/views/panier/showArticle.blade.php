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
						
                    <img src="{{asset('storage/images/produits/' .$produits->image_produit)}}" alt="$produits->image_produit" style="height: 400px; width: 500px;">
						
					</div>
					<div class="details col-md-6">
						<h3 class="product-title">{{$produits->name}} <strong class="badge badge-pill badge-info">{{$stock}}</strong></h3>

						<p class="product-description">{!! str_replace(';', ';<br>', e($produits->description)) !!}</p>
						<h4 class="price">current price: <span>{{$produits->getPrice()}}</span></h4>
                        
						@if($stock ==="disponible")
							<form action="{{ route('panier.ajouter') }}" method="post">
								@csrf
								<div class="action">
									<input type="hidden" name="id" value="{{$produits->id}}">
									<input type="hidden" name="name" value="{{$produits->name}}">
									<input type="hidden" name="price" value="{{$produits->price}}">
									<button class="add-to-cart btn btn-default" type="submit">Ajouter au panier</button>
								</div>
							</form>
						@endif


					</div>
				</div>
			</div>
		</div>
	</div>

@endsection