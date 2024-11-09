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

                @if(session('error'))
                <div class="alert alert-danger">
                    {{session('error')}}
                </div>
                @endif
            </div>
        </div>

            
        <div class="" style="margin-top: 5em; margin-left: 8em; background-color: silver;  padding: 1em; width: 42em;">
            <!-- small box -->
            <form action="{{ route('dashboard.compte.valider_transfert')}}" method="post">
                @csrf
                <div style="display: flex; flex-direction: row;">
                    <!--compte payeur-->
                    <div class="small-box bg-info " style=" margin-left:2em; width: 17em;">
                        <div class="inner">               
                            <select class="form-select " aria-label="Large select example" name="envoyeur_id" required>
                                <option value="">choisir le compte envoyeur</option>
                                @foreach($comptes as $compte)
                                    <option value="{{$compte->id}}">{{$compte->nom}}</option>
                                @endforeach
                            </select>
                            <label for="montant" ></label>
                            <input type="text" class="form-control" name="montant" id="mantant" placeholder="entrer le montant" required>
                        </div>
                    </div><!--/comptes payeur-->
                    <div style="margin-top: 2.4em; margin-left: 1em;">
                        <h1><i class="bi bi-arrow-left-right"></i></h1>
                    </div>
                    <!--compte receveur-->
                    <div class="small-box bg-info " style="width: 17em; margin-left: 2em;">
                        <div class="inner">               
                            <select class="form-select " aria-label="Large select example" name="receveur_id" required>
                                <option value="">choisir le compte receveur</option>
                                @foreach($comptes as $compte)
                                    <option value="{{$compte->id}}">{{$compte->nom}}</option>
                                @endforeach
                            </select>
                            <label for="montant" ></label>
                            <button type="submit" class="btn btn-primary form-control">transferer</button>
                        </div>
                    </div><!--/comptes receveur-->
                </div>
                    
            </form>
            
        </div>
    </div>
</section>



@endsection

@section('javascript')

@endsection