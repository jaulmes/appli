<div class="container py-5">
    <div class="row g-5 align-items-center">
    <!-- Texte de présentation -->
    <div class="col-md-12 col-lg-7" data-aos="fade-right" data-aos-delay="200">
        <span style="font-size: 3em;" class="mb-5  text-info display-2  fw-bold">Vente & Installation d'Équipements Solaires</span>
        <hr />
    </div>
    <!-- Carousel de présentation -->
    <div class="col-md-12 col-lg-5" style=" text-align: center;" data-aos="fade-left" data-aos-delay="600">
        <h5 class=" pl-3 mb-3 text-white fw-bold">Votre spécialiste en solutions solaires</h5>
        <div id="carouselId" class="carousel slide position-relative shadow-lg rounded-4 overflow-hidden" data-bs-ride="carousel">
        <livewire:front-end-presentation-view />
        </div>
    </div>
    </div><br/>
    <div class=" py-2 position-relative" style="overflow: hidden;">
    <div class="marquee-wrapper w-100">
        <div class="marquee-text text-white">
        Basés à Douala, Cameroun, nous vous offrons des solutions d'énergie renouvelable et durable pour vos projets résidentiels et professionnels.
        </div>
    </div>
    </div>

    <style>
    .marquee-wrapper {
        position: relative;
        height: 1.5em;
        overflow: hidden;
    }

    .marquee-text {
        display: inline-block;
        white-space: nowrap;
        padding-left: 100%;
        animation: scroll-left 20s linear infinite;
    }

    @keyframes scroll-left {
        0% {
        transform: translateX(0%);
        }
        100% {
        transform: translateX(-100%);
        }
    }
    </style>
</div>