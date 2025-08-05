@extends('dashboard.main')

@section('content')

<div >


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
    
    
    <div class="row" style="font-size: small;">
        <div class="col-15">
            <div class="card" style="margin-top: 2em">
                <div class="card-header">
                    <h3 class="card-title "><strong >Journal des Activites</strong></h3>
                    
                    <div class="card-tools">
                        
                        <div class="input-group input-group-sm" style="width: 150px;">
                           <form  method="get" action="{{ route('transaction.mesTransactions') }}">
                                @csrf
                                <select name="month" id="month" onchange="this.form.submit()" id="transactionMonth">
                                    @for($i = 0; $i < 12; $i++)
                                        @php
                                            $month = Carbon\Carbon::now()->subMonths($i)->format('Y-m');
                                        @endphp
                                        <option value="{{ $month }}" {{ $currentMonth == $month ? 'selected' : '' }}>
                                            {{ Carbon\Carbon::parse($month)->format('F Y') }}
                                        </option>
                                    @endfor
                                </select>
                            </form>
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
                                @can('VOIR_UTILISATEURS')
                                    <th>Prix achat</th>
                                @endcan
                                <th>Montant Verse</th>
                                <th>Moyen payement</th>
                                <th>Produits</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Heure</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr style="font-size: xx-small;">
                                <td>{{$transaction->nomClient ?? $transaction->recus->clients->nom?? '-' }}</td>
                                <td>{{$transaction->numeroClient}}</td>
                                <td> {{$transaction->user->name ?? $transaction->recus->users->name ?? 'Auccun nom'}}</td>
                                @can('VOIR_UTILISATEURS')
                                    <td> {{$transaction->prixAchat}}</td>
                                @endcan
                                <td> {{$transaction->montantVerse ?? $transaction->recus->montant_recu?? '-'}}</td>
                                <td> {{$transaction->compte->nom ?? '-'}}</td>
                                <td style="font-size: xx-small;" class="col-12 col-md-3"> 
                                    @if($transaction->charge_id)
                                        {{$transaction->charges->titre}}
                                    @elseif($transaction->recus)
                                        @if($transaction->recus->installations)
                                            @foreach($transaction->recus->installations->produits as $produit)
                                                Qte: {{ $produit->pivot->quantity }} 
                                                - PU: {{ $produit->pivot->price }} 
                                                - {{ $produit->name }} <br>
                                            @endforeach
                                        @elseif($transaction->recus->ventes)
                                            @foreach($transaction->recus->ventes->produits as $produit)
                                                Qte: {{ $produit->pivot->quantity }} 
                                                - PU: {{ $produit->pivot->price }} 
                                                - {{ $produit->name }} <br>
                                            @endforeach
                                        @else
                                            hello
                                        @endif
                                    @else
                                        @forelse($transaction->produits as $produit)
                                            Qte: {{ $produit->pivot->quantity }} 
                                            - PU: {{ $produit->pivot->price }} - {{ $produit->name }} <br>
                                        @empty
                                            {{ $transaction->produit }}
                                        @endforelse
                                    @endif
                                </td>
                                <td>{{$transaction->type}}</td>
                                <td>{{$transaction->created_at}}</td>
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

    <script>
        function updateBilanMonth() {
            const selectedMonth = document.getElementById('transactionMonth').value;
            document.getElementById('bilanMonth').value = selectedMonth;
        }
    </script>

@endsection