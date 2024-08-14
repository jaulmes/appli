@extends('dashboard.main')

@section('content')

<section class="h-100 h-custom">
  <div class="container h-100 py-5">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="col-4 pt-1">
            <a href="{{route('panier.monPanier')}}" class="text-mixted" style="position: fixed; margin-left: 70em;">panier<span class="badge badge-pill badge-dark" >{{ $quantite}} </span></a>
        </div>

      @if(session('message'))
        <div class="alert alert-success">
            {{session('message')}}
        </div>
        @endif

        @if(session('erreur'))
        <div class="alert alert-danger">
            {{session('erreur')}}
        </div>
        @endif
        <div class="table-responsive">
        <div class="row row-cols-1 row-cols-md-3 g-4">
          @foreach($produits as $produit)
          <div class="col" style="margin-bottom: 20px;">
            <div class="card h-100">
              <img src="{{asset('storage/images/produits/'.$produit->image_produit)}}"  class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">{{$produit->name}}</h5>
                <p class="card-text">{{$produit->description}}</p>
                
                <p class="card-text">Prix: {{$produit->getPrice()}} </p>
              </div>
              <div class="row" style="margin-left: 1em; padding-bottom: 2em">
                <a href="{{ route('produit.detail', $produit->id)}} ">
                    <button class="btn btn-warning px-2">
                        Voir l'article
                    </button>
                </a>
                <form action="{{ route('panier.ajouter') }}" method="post">
                  @csrf
                  <div class="action">
                    <input type="hidden" name="id" value="{{$produit->id}}">
                    <input type="hidden" name="name" value="{{$produit->name}}">
                    <input type="hidden" name="price" value="{{$produit->price}}">
                    <button class="add-to-cart btn btn-primary" type="submit" style="margin-left: 3em;">Ajouter au panier</button>
                  </div>
                </form>
              </div>

            </div>
          </div>
          @endforeach
        </div>
        </div>
        <!--mon panier-->
        <div class="card shadow-2-strong mb-5 mb-lg-0" style="border-radius: 16px;">
          <div class="card-body p-4">

            <div class="row">
              <h1><strong><u>Mon panier</u></strong></h1> <br>

            <table class="table">
            <thead>
              <tr>
                <th scope="col" class="h5">Titre</th>
                <th scope="col">Prix Unitaire</th>
                <th scope="col">Quantitée</th>
                <th scope="col">Prix Total</th>

              </tr>
            </thead>
            <tbody>
            @foreach( Cart::getContent()  as $produit)
              <tr>
                <th scope="row">
                      <p class="mb-2">{{$produit->name}}</p>
                </th>

                <th class="align-middle">
                  <p class="mb-0" style="font-weight: 500;">{{$produit->price}} </p>
                </th>
                <th class="align-middle">
                  <p class="mb-0" style="font-weight: 500;">{{$produit->quantity}} </p>
                </th>
                <th class="align-middle">
                  <p class="mb-0" style="font-weight: 500;">{{$produit->price * $produit->quantity}} </p>
                </th>

              </tr>
            @endforeach
              
            </tbody>
          </table>
               
            <div class="col-md-6 col-lg-4 col-xl-3 mb-4 mb-md-0">

              <div class="col-lg-4 col-xl-3">
                <div class="d-flex justify-content-between" style="font-weight: 500;">
                  <p class="mb-2">total: </p>
                  <p class="mb-2" style="margin-left: 50em;">{{ Cart::getTotal()}}  </p>
                </div>
              </div>


                <!-- Button trigger modal -->


                <!-- Modal -->
                <form action="{{ route('panier.enregistrer')}}" method="post">
                  @csrf
                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">enregistrement de la vente</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>

                        <div class="modal-body">
                          <div class="row">
                            <div class="form-group">
                              <label for="nom">nom du client</label>
                              <input class="form-control" type="text" name="nom" id="nom">
                            </div>
                            <div class="form-group">
                              <label for="numero">numero du client</label>
                              <input class="form-control" type="number" name="numero" id="numero">
                            </div>
                          </div>

                          <div class="row">
                            <div class="form-group">
                              <label for="montantVerse">montant versé</label>
                              <input class="form-control" type="number" name="montantVerse" id="montantVerse">
                            </div>
                            <div class="form-group">
                              <select class="form-control" name="modePaiement" id="">
                                <option selected disabled > mode de paiement</option>
                                <option value="Orange Money">Orange Money</option>
                                <option value="MTN MOMO">MTN MOMO</option>
                                <option value="Cash">Cash</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>

            </div>

          </div>
        </div>


        

      </div>
    </div>
  </div>
</section>



@endsection

@section('javascript')

@endsection