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
        <livewire:bilan-classement-client/>
    </div>

    
    <!-- /.card-body -->
</div>



@endsection

@section('javascript')

@endsection