@extends('dashboard.main')

@section('head')


  <script src="<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script></script>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="./../plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="./../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./../dist/css/adminlte.min.css">




  <!-- Select2 -->
  <link rel="stylesheet" href="./../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="./../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 






  <!-- DataTables -->
  <link rel="stylesheet" href="./../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="./../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


@endsection

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

        <div class="table-responsive"id="example1">
            <div>
                <form action="{{ route('produit.search')}}" method="get">
                <input type="text" placeholder="chercher un produit..." name="q"/>
                <button type="submit" > <i class="fas fa-search"></i> </button>
                </form>
                
            </div>

          <div class="row row-cols-1 row-cols-md-3 g-4" >
            @foreach($produits as $produit)
            <div class="col" style="margin-bottom: 20px; margin-left: 3px; margin-right: -5.4em; ">
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
                          
                          @if($produit->getStock() ==="disponible")
                            <form action="{{ route('panier.ajouter') }}" method="post">
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
                          @endif
                          
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>




        <!--mon panier-->
        <div  style="width:22em; position:absolute; margin-left:70em; margin-top:-50em; font-size:12px ">
        
        
        <div class="card shadow-2-strong mb-5 mb-lg-0" style="border-radius: 16px;">
          <div class="card-body p-4">

            <div class="row">
              <h6><strong><u>Mon panier</u></strong></h6> <br>

            <table class="table">
            <thead>
              <tr>
                <th scope="col" class="h6">Nom</th>
                <th scope="col">P U</th>
                <th scope="col">QTE</th>
                <th scope="col">Prix T</th>
                <th scope="col">Action</th>

              </tr>
            </thead>
            <tbody style="padding-left:0">
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
               
            <div class="col-md-6 col-lg-4 col-xl-3 mb-4 mb-md-0">

              <div class="col-lg-4 col-xl-3">
                <div class="d-flex justify-content-between" style="font-weight: 500;">
                  <p class="mb-2">total: </p>
                  <p class="mb-2" style="margin-left: 10em;">{{ Cart::getTotal()}}  </p>
                </div>
              </div>



                  
                  
                  <button type="button" style="width: 10em; margin-left:6em;  font-size:10px"  class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                    Valider l'achat
                  </button>

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
                              <input class="form-control" type="number" name="montantVerse" id="montantVerse" value="{{ Cart::getTotal()}}">
                            </div>
                            <div class="form-group">
                              <select class="form-control" name="modePaiement" id="">
                                <option selected disabled > mode de paiement</option>
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
  </div>
</section>



@endsection

@section('javascript')

@endsection