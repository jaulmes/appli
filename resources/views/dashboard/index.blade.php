@extends('dashboard.main')

@section('content')
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            
            <div class="small-box bg-info">
              <div class="inner">
                <h3><U class="bg-warning">{{$montant}}</U></h3> francs CFA
                <h5>Montant dans les comptes: </h5>

              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{route('dashboard.compte')}}" class="small-box-footer">Details <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-5 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h4>VALEUR TOTALE DES PRODUITS SOLERGY DISPONIBLE EN STOCK</h>
                <p><u>TOTAL ACHATS </u>:<strong class="bg-warning">{{$total_achat_formate}}</strong> </p>
                <p><u>TOTAL VENTES </u>: <strong class="bg-warning">{{$total_vente_formate}}</strong> </p>
                <p><u>TOTAL TECHNICIEN </u>: <strong class="bg-warning">{{$total_technicien_formate}}</strong> </p>

              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
          <div class="col-lg-5 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h4>BENEFICE DU MOI EN COURS SUR LES VENTES DES PRODUIT</h>
                <p><u>TOTAL DES BENEFICES </u>:<strong class="bg-warning">{{$benefice_formate}}</strong> francs CFA</p>

              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

        </div>
        @endsection