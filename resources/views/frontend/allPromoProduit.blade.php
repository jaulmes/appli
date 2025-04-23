@extends('dashboard.main')

@section('head')
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Ionicons CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/6.1.2/ionicons.min.css">
@endsection
@section('content')

<div>
    <a href="{{ route('frontend.admin')}}">
        <button class="btn btn-danger">Retour</button>
    </a>
</div>

<div>
    <livewire:front-end-all-promo-produit-admin/>
</div>
            <!-- /.card --> 
@endsection