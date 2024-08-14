@extends('dashboard.main')

@section('content')

<div class="">
    <div class="">
        <div>
            <form  method="post" action="{{ route('transaction.filter') }}">
                @csrf
                <label for="month">Month:</label>
                <select id="month" name="month" >
                    @for ($i = 01; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ date('F', mktime(00, 00, 00, $i, 01, 2024)) }}</option>
                    @endfor
                </select>
                <input type="submit" value="valider">
            </form>
        </div>
    </div>

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
    <!-- END: Alert -->
    
    
    <div class="row">
<div class="col-12">
<div class="card" style="margin-top: 2em">
<div class="card-header">
<h3 class="card-title "><strong>Mes Charges</strong></h3>
<div class="card-tools">
<div class="input-group input-group-sm" style="width: 150px;">
<input type="text" name="table_search" class="form-control float-right" placeholder="Search">
<div class="input-group-append">
<button type="submit" class="btn btn-default">
<i class="fas fa-search"></i>
</button>
</div>
</div>
</div>
</div>

<div class="card-body table-responsive p-0" style="height: 400px;">
<table class="table table-head-fixed ">
<thead>
<tr>
                <th>Nom client</th>
                <th>Num client</th>
                <th>Auteur</th>
                <th>Prix achat</th>
                <th>Prix vente</th>
                <th>Moyen payement</th>
                <th>Produits</th>
                <th>Type</th>
                <th>Date</th>
                <th>Heure</th>
</tr>
</thead>
<tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{$transaction->nomClient}}</td>
                <td>{{$transaction->numeroClient}}</td>
                <td> {{$transaction->user->name}}</td>
                <td> {{$transaction->prixAchat}}</td>
                <td> {{$transaction->montantVerse}}</td>
                <td> {{$transaction->compte->nom ?? ''}}</td>
                <td> {{$transaction->produit}}</td>
                <td>{{$transaction->type}}</td>
                <td>{{$transaction->date}}</td>
                <td>{{$transaction->heure}}</td>
            </tr>
            @endforeach
</tbody>
</table>
</div>

</div>

</div>
</div>
    
    
    
</div>
@endsection

@section('javascript')



@endsection