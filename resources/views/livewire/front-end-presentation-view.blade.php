<div>
  <div id="carouselExampleIndicators" class="carousel slide d-none d-lg-block" data-bs-interval="1000" data-bs-ride="carousel">
    <!-- Indicateurs -->
    <div class="carousel-indicators">
      @foreach ($presentations as $index => $presentation)
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index }}" 
                class="@if($index === 0) active @endif" aria-label="Slide {{ $index + 1 }}"></button>
      @endforeach
    </div>

    <!-- Contenu unique du carousel -->
    <div class="carousel-inner" style="border: solid gold 4px; border-radius: 20px;">
      @foreach ($presentations as $index => $presentation)
        <div class="carousel-item @if($index === 0) active @endif">
          <!-- Image responsive avec style conditionnel -->
          @php
              $image1 = public_path('images/presentations/'. $presentation->image);
              $image2 = public_path('storage/images/presentations/'. $presentation->image);
              $url = file_exists($image1)? asset('images/presentations/'. $presentation->image)
                                          : asset('storage/images/presentations/' . $presentation->image);
          @endphp
          <img src="{{$url }}"
              class="d-block w-100" 
              alt="Image {{ $index + 1 }}"
              style="height: 20em; @media (max-width: 992px) { border: solid gold 4px; border-radius: 20px; }">
        </div>
      @endforeach
    </div>

    

    <!-- Contrôles -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>

  <div id="carouselExampleControls" style="margin-left: 1.6em;" class="carousel slide d-block d-lg-none" data-bs-interval="1000" data-bs-ride="carousel">
    <div class="carousel-inner" >
      @foreach ($presentations as $index => $presentation)
        <div class="carousel-item @if($index === 0) active @endif">
          <!-- Image responsive avec style conditionnel -->
           @php
              $image1 = public_path('images/presentations/'. $presentation->image);
              $image2 = public_path('storage/images/presentations/'. $presentation->image);
              $url = file_exists($image1)? asset('images/presentations/'. $presentation->image)
                                          : asset('storage/images/presentations/' . $presentation->image);
          @endphp
          <img src="{{$url }}"
              class="d-block w-100" 
              alt="Image {{ $index + 1 }}"
              style=" border: solid gold 4px; border-radius: 20px; height: 20em; width: 100%;">
        </div>
      @endforeach
    </div>
  </div>

</div>