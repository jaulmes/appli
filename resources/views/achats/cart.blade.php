@extends('dashboard.main')

@section('content')

<section class="h-100 h-custom">
    <div class="container h-100 py-5">

          <div class="container-xl px-4 mt-n4">
              @if (session()->has('message'))
              <div class="alert alert-success alert-icon" role="alert">
                  <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                  <div class="alert-icon-aside">
                      <i class="far fa-flag"></i>
                  </div>
                  <div class="alert-icon-content">
                      {{ session('message') }}
                  </div>
              </div>
              @endif
          </div>
          <div class="container-xl px-4 mt-n4">
              @if (session()->has('error'))
              <div class="alert alert-danger alert-icon" role="alert">
                  <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                  <div class="alert-icon-content">
                      {{ session('error') }}
                  </div>
              </div>
              @endif
          </div>
        <div class="col">

            <div class="table-responsive" style="display: flex; flex-direction: row">
                <div class="card-body">
                    <div class="tab-content p-0">
                        <div class="row row-cols-1 row-cols-md-3 g-3" >
                            @foreach($produits as $produit)
                            <div class="col" style="margin-bottom: 20px; margin-left: 5px; margin-right: -5em; ">
                              <div class="row " data-aos="fade-left" >
                                <div class="col-lg-10 col-md-6">
                                    <div class="card h-80" style="width:9em; " >
                                        <strong class="badge  badge-danger">{{$produit->getAlert()}}</strong>
                                      @if($produit->getStock() ==="disponible")
                                        <strong class="badge  badge-info">{{$produit->getStock()}}</strong>
                                      @endif
                                      
                                      @if($produit->getStock() ==="indisponible")
                                        <strong class="badge  badge-danger">{{$produit->getStock()}}</strong>
                                      @endif
                                        <img src="{{asset('storage/images/produits/'.$produit->image_produit) ?? 'bjr'}}" class="img-fluid" alt="" style="height: 5em; width: 100%">
                                        <div class="member-info" style="font-size: 12px;">
                                            <h7 style="margin-bottom: -0.1em;"><u>Nom</u>: {{$produit->name}}</h7>
                                            <p class="card-text" style="margin-bottom: -0.1em;"><u>Desc</u>: {{$produit->getDescription()}}</p>
                                            <p class="card-text" style="margin-bottom: -0.1em; "><u>Prix</u>: <strong style="background-color:green"> {{$produit->getPrice()}}</strong>  </p>
                                            <div class="row" style="margin-left: 0.2em; padding-bottom: 0.01em; margin-top: 0.5em;">
                                                <a href="{{ route('produit.detail', $produit->id)}} ">
                                                    <button class="btn btn-warning px-1" >
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </a>
                                    
                                                <form action="{{ route('achats.storeCart') }}" method="post">
                                                  @csrf
                                                  <div class="action">
                                                    <input type="hidden" name="id" value="{{$produit->id}}">
                                                    <input type="hidden" name="name" value="{{$produit->name}}">
                                                    <input type="hidden" name="price" value="{{$produit->price}}">
                                                    <button class="add-to-cart btn btn-primary px-1" type="submit" style="margin-left: 2em; margin-top:-3.5em">
                                                      <i class="bi bi-plus"></i>
                                                    </button>
                                                  </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                            @endforeach
                            <!--le surplus de div-->
                        </div>
                    </div>
                </div>
                <!--mon panier-->
                <div >
                    <div class="card-body p-4">
                        <div class="row card shadow-2-strong mb-lg-0 " id="monPanier" style="position: fixed; width: 25em; padding-bottom: 3em; padding-top: 3em; margin-top: -7em; margin-left: -20em;  font-size:12px ">
                            <h6><strong><u>Mon panier</u></strong></h6> <br>
                            <table class="table table-responsive " style="overflow-y: visible; ">
                                <thead>
                                    <tr>
                                        <th scope="col" class="h6">Nom</th>
                                        <th scope="col">P U</th>
                                        <th scope="col">QTE</th>
                                        <th scope="col">Prix T</th>
                                        <th scope="col">Action</th>
                                     </tr>
                                </thead>
                                <tbody class="card-body table-responsive p-0" style="height: 200px;"> 
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
                                        <th>
                                            <form action="{{route('produit.retirer', $produit->id)}}" method="get" >
                                            @csrf
                                                <button type="submit"  class="btn btn-danger" >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                          </form>
                                        </th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            
                            <div class="col-lg-4 col-xl-3">
                                <div class="d-flex justify-content-between" style="font-weight: 500;">
                                    <p class="mb-2">total: </p>
                                    <p class="mb-2" style="margin-left: 10em;">{{ Cart::getTotal()}}  </p>
                                </div>
                            </div>
                            <!-- Button trigger modal -->
                            <form action="{{url('detruire')}}" method="get">
                                @csrf
                                <button type="submit"  class="btn btn-danger" style="width: 8em; font-size:10px">
                                  vider le panier
                                </button>
                            </form>
                            <button type="button" style="width: 8em; margin-left:10em; margin-top:-4.7em; font-size:10px"  class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                                Valider l'achat
                            </button>
                        </div>

                       
                        <div class="col-md-6 col-lg-4 col-xl-3 mb-4 mb-md-0">
                            <!-- Modal -->
                            <form action="{{ route('achat.valider')}}" method="post">
                              @csrf
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">enregistrement de l'achat'</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="row">
                                                <div class="form-group">
                                                  <label for="montantVerse">montant versé</label>
                                                  <input class="form-control" type="number" name="montantVerse" id="montantVerse" value="{{ Cart::getTotal()}}" required>
                                                </div>
                                                
                                                <div class="form-group">
                                                  <select class="form-control" name="modePaiement" id="" required>
                                                    <option selected disabled> mode de paiement</option>
                                                    @foreach($comptes as $compte)
                                                    <option value="{{$compte->id}}">{{$compte->nom}}</option>
                                                    @endforeach
                                                  </select>
                                                </div>
                                                <div class="form-group">
                                                  <label for="impot">Accepter</label>
                                                  <input type="checkbox" name="impot" id="impot">
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