@extends('dashboard.main')

@section('head')

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Ionicons CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/6.1.2/ionicons.min.css">
@endsection
@section('content')
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <livewire:front-end-produit-promo/>
        </div>

        <div class="card">
          <livewire:front-end-service-admin/>
        </div>

      </div>
      <!-- /.col-md-6 -->
      <div class="col-lg-6">
        <div class="card">
          <livewire:front-end-presentation-view-admin/>
        </div>
        <!-- /.card -->
        <div class="card">
          <livewire:front-end-realisation-admin/>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card">
          <livewire:front-end-annonce-admin/>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection