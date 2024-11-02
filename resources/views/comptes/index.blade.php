@extends('dashboard.main')

@section('content')

<section class="h-100 h-custom">
    <div class="container h-100 py-5">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">


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
            </div>
        </div>
        <a href="{{ route('dashboard.compte.create')}}" ><button class="btn btn-primary">ajouter un moyen de paiement</button></a>
            
        <div class="row row-cols-1 row-cols-md-4 g-3" style="margin-top: 10px;">
            <!-- small box -->
             
            @foreach($comptes as $compte)
            <div class="small-box bg-info ml-5">
              <div class="inner">
                <h5>Nom: {{$compte->nom}} </h5>
                <h5>Montant: {{$compte->montant}} fcfa</h5>
                @can('MODIFIER_COMPTE')
                    <div class="d-flex">
                        <i class="ion ion-bag">
                            <buttom><a href="{{ route('dashboard.compte.edit', $compte->id)}}">modifier</a></buttom>
                        </i>
                        @can('SUPPRIMER_COMPTE')
                            <i class="ion ion-bag ml-5">
                                <form action="{{ route('dashboard.compte.delete', $compte->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-warning" type="submit" onclick="return confirm('voulez vous suprimer ce compte?')">suprimer</button>
                                </form>
                            </i>
                        @endcan
                    </div>
                @endcan
                
              </div>

            </div>
            @endforeach
          </div>
    </div>
</section>



@endsection

@section('javascript')

@endsection