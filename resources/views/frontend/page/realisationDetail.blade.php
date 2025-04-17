@extends('frontend.layout.index')

@section('content')
<div class="container py-5" style="margin-top: 10em;">
  <div class="row g-5">
    <!-- Galerie principale avec carousel -->
    <div class="col-lg-8">
      <div id="realisationCarousel" class="carousel slide shadow-lg" data-bs-ride="carousel">
        <div class="carousel-inner rounded-4 overflow-hidden">
          @foreach(['img1', 'img2', 'img3', 'img4'] as $img)
            @if($realisation->$img)
              <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <img src="{{ asset('storage/images/Realisations/'.$realisation->$img) }}" 
                     class="d-block w-100 zoom-image" 
                     alt="{{ $realisation->name }}"
                     style="height: 600px; object-fit: cover;">
                <div class="carousel-overlay"></div>
              </div>
            @endif
          @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#realisationCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#realisationCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

      <!-- Galerie miniature -->
      @if($realisation->img2)
      <div class="row g-3 mt-3">
        @foreach(['img1', 'img2', 'img3', 'img4'] as $img)
          @if($realisation->$img)
            <div class="col-3">
              <img src="{{ asset('storage/images/Realisations/'.$realisation->$img) }}" 
                   class="img-fluid cursor-pointer thumbnail-img"
                   data-bs-target="#realisationCarousel"
                   data-bs-slide-to="{{ $loop->index }}"
                   style="height: 150px; object-fit: cover;"
                   alt="Thumbnail">
            </div>
          @endif
        @endforeach
      </div>
      @endif
    </div>

    <!-- Détails du projet -->
    <div class="col-lg-4">
      <h1 class="fw-bold display-5 mb-4">{{ $realisation->name }}</h1>
      
      <div class="project-meta mb-5">
        <div class="d-flex align-items-center mb-3">
          <i class="fas fa-calendar-alt me-2 text-primary"></i>
          <span>{{ $realisation->created_at->format('d/m/Y') }}</span>
        </div>
      </div>

      <h4 class="mb-3">Description du projet</h4>
      <p class="lead">{{ $realisation->description }}</p>

      
    </div>
  </div>
</div>

<style>
.carousel-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.5) 100%);
}

.zoom-image {
  transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.carousel-item:hover .zoom-image {
  transform: scale(1.05);
}

.thumbnail-img {
  transition: all 0.3s ease;
  border: 2px solid transparent;
  border-radius: 8px;
}

.thumbnail-img:hover {
  transform: translateY(-5px);
  border-color: var(--bs-primary);
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.thumbnail-img.active {
  border-color: var(--bs-primary);
  transform: scale(0.95);
}

.project-meta span {
  font-weight: 500;
  color: #444;
}

.technical-specs li {
  padding: 12px;
  background: rgba(0, 102, 255, 0.05);
  border-radius: 8px;
  transition: transform 0.3s ease;
}

.technical-specs li:hover {
  transform: translateX(10px);
  background: rgba(0, 102, 255, 0.1);
}
</style>

<script>
document.querySelectorAll('.thumbnail-img').forEach(img => {
  img.addEventListener('click', function() {
    document.querySelectorAll('.thumbnail-img').forEach(t => t.classList.remove('active'));
    this.classList.add('active');
  });
});

// Initialisation du carousel avec paramètres
const carousel = new bootstrap.Carousel('#realisationCarousel', {
  interval: 5000,
  pause: 'hover',
  wrap: true
});
</script>
@endsection