@extends('dashboard.main')

@section('extra-meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

<section class="h-100 h-custom" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="card">
          <div class="card-body p-4">
            @if(session('succes'))
              {{ session('succes')}}
            @endif

            @if(session('erreur'))
              {{ session('erreur')}}
            @endif

            <div class="row">

              <div class="col-lg-7">
                <h5 class="mb-3"><a href=" {{ route('panier.index')}}" class="text-body"><i
                      class="fas fa-long-arrow-alt-left me-2"></i>continuer mes achats</a></h5>
                <hr>

                <div class="d-flex justify-content-between align-items-center mb-4">
                  <div>
                    <p class="mb-1">panier d'achet</p>
                    <p class="mb-0">vous avez {{ Cart::getContent()->count()}} article dans votre panier</p>
                  </div>
                  <div>
                    <p class="mb-0"><span class="text-muted">Sort by:</span> <a href="#!"
                        class="text-body">price <i class="fas fa-angle-down mt-1"></i></a></p>
                  </div>
                </div>

                @foreach($panier as $produit)
                <div class="card mb-3">
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div class="d-flex flex-row align-items-center">
                         <div>
                          <img
                            src=" {{asset('storage/images/produits/'.$produit->model->image_produit) }}  "
                            class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
                        </div> 
                        <div class="ms-3">
                          <h5>{{ $produit->model->name }}</h5>

                        </div>
                      </div>
                      <div class="d-flex flex-row align-items-center">Quantitée
                        <div style="width: 50px;">
                          <h5 class="fw-normal mb-0">

                              <select name="quantity" id="quantity" data-id="{{$produit->id}}" data-stock="{{$produit->model->stock}}" class="custom-select">
                                @for($i=0; $i< 10; $i++ )
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                              </select>
                          {{$produit->quantity}}

                          </h5>
                        </div>
                        <div style="width: 80px;">
                          <h5 class="mb-0">{{$produit->price}}</h5>
                        </div>
                        <form action="{{ route('panier.delete' ,[$produit->id]) }}" method="post">
                          @method('delete')
                          @csrf
                            <button type="submit"><i class="fas fa-trash-alt" style="color: red;"></i></button>
                        </form>
                        
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach


              </div>
              <div class="col-lg-5">

                <div class="card bg-primary text-white rounded-3">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                      <h5 class="mb-0">detail du panier</h5>
                    </div>

                    

                    </form>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                      <p class="mb-2">total</p>
                      <p class="mb-2">{{ Cart::getTotal() }}</p>
                    </div>

 

                    <div class="d-flex justify-content-between mb-4">
                      <p class="mb-2">Total(Incl. taxes)</p>
                      <p class="mb-2">{{Cart::getSubtotal()}}</p>
                    </div>

                    <button type="button" class="btn btn-info btn-block btn-lg">
                      <div class="d-flex justify-content-between">
                        <span>{{Cart::getSubtotal()}}</span>
                        <span>Etablir la facture <i class="fas fa-long-arrow-alt-right ms-2"></i></span>
                      </div>
                    </button>

                  </div>
                </div>

              </div>

            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="{{ asset('jquery-3.7.1.min.js')}}"></script>
<script >
  var selects = document.querySelectorAll('#quantity')

  Array.from(selects).forEach((element) =>{
    console.log(element)

      element.addEventListener('change', function(){
        var id = element.getAttribute('data-id')
        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        var stock = element.getAttribute('data-stock')
        fetch(
            `panier/${id}`,
            {
                headers: {
                  "content-type": "application/json",
                  "Accept": "application/json, text-plain, */*",
                  "X-Requested-with": "XMLHttpRequest",
                  "X-CSRF-TOKEN": token
                },
                method: 'patch',
                body: JSON.stringify({
                  quantity: this.value,
                  stock: stock
                })
                
            }
            
        ).then((data)=>{
          console.log(data)
          location.reload()
        }
        ).catch((error)=>{
          console.log(error)
        })
      })
  })
  console.log(selects)
</script>
@endsection