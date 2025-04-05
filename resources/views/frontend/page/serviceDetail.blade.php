@extends('frontend.layout.index')

@section('content')
<div class="container py-5" style="margin-top: 10em;">
  <div class="row">
    <!-- Image du service -->
    <div class="col-md-6">
      <div class="position-relative overflow-hidden image-zoom-container rounded shadow">
        <img src="{{ asset('storage/images/services/'.$service->image) }}" alt="{{ $service->name }}" class="img-fluid w-100 h-100 object-fit-cover transition-all zoom-image">
      </div>
    </div>

    <!-- Détails du service -->
    <div class="col-md-6">
      <h1 class="fw-bold">{{ $service->name }}</h1>

      <!-- Description -->
      <p class="mb-4">{{ $service->description }}</p>

    </div>
  </div>
</div>

<!-- Styles additionnels -->
<style>
  .image-zoom-container {
    transition: transform 0.3s;
    overflow: hidden;
    max-height: 400px;
  }
  .zoom-image {
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .image-zoom-container:hover .zoom-image {
    transform: scale(1.2);
  }
</style>
@endsection
