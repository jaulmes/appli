<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <!-- Indicateurs -->
  <div class="carousel-indicators">
    @foreach ($presentations as $index => $presentation)
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index }}" 
              class="@if($index === 0) active @endif" aria-label="Slide {{ $index + 1 }}">
      </button>
    @endforeach
  </div>

  <!-- Contenu du carrousel -->
  <div class="carousel-inner">
    @foreach ($presentations as $index => $presentation)
      <div class="carousel-item @if($index === 0) active @endif">
        <img src="{{ asset('storage/images/presentations/'.$presentation->image) }}" style="height: 20em;" class="d-block w-100" alt="Image {{ $index + 1 }}">
      </div>
    @endforeach
  </div>

  <!-- Boutons précédent / suivant -->
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
