@extends('frontend.layout.index')

@section('content')
<livewire:front-end-all-service/>

<!-- Styles additionnels -->
<style>
  .image-zoom-container {
    transition: transform 0.3s;
    overflow: hidden;
  }
  .zoom-image {
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .image-zoom-container:hover .zoom-image {
    transform: scale(1.4);
  }
  .hover-scale:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08) !important;
  }
  .card-img-overlay {
    background: linear-gradient(180deg, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.1) 50%);
    z-index: 1;
  }
  .transition-all {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
  /* Opacité de l'overlay lors du hover */
  .hover-opacity-100:hover {
    opacity: 1 !important;
  }
</style>
@endsection