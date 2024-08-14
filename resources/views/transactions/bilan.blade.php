@extends('dashboard.main')

@section('content')
                <a href="{{route('transaction.index')}}" style="margin-right: 45em">
                <button type="button"  class="btn btn-danger">retour</button>
            </a>
<div class="card">

    <div class="card-header">

        <h1 class="card-title" style="margin-left:25em">Billan mensuel</h1>
        
    </div>

    <!-- END: Alert -->
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Chiffre d'affaire</th>
                    <th>Benefices</th>
                    <th>Charge</th>
                    <th>Achat des produit vendu</th>
                    <th>commissions</th>
                    <th>Investissements</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$chiffreAffaire}}</td>
                    <td>{{$benefices}}</td>
                    <td>{{$montantCharge}}</td>
                    <td>{{$montantAchat}}</td>
                    <td></td>
                    <td>{{$investissement}}</td>
                </tr>
                
            </tbody>

        </table>
    </div>

    
    <!-- /.card-body -->
</div>



@endsection

@section('javascript')

@endsection