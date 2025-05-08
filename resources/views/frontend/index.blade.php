<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Solergy Solutions SARL - Vente et Installation d'Équipements Solaires à Douala, Cameroun</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Meta SEO -->
  <meta name="description" content="Solergy Solutions SARL, spécialiste de la vente et de l'installation d'équipements solaires à Douala, Cameroun. Profitez d'une énergie renouvelable et durable pour vos projets résidentiels et professionnels.">
  <meta name="keywords" content="Solergy Solutions, équipements solaires, Douala, Cameroun, installation solaire, vente panneaux solaires, énergie renouvelable">
  <meta name="author" content="Solergy Solutions SARL">
  <link rel="canonical" href="https://www.solergy-solutions.com/">

  <!-- Open Graph / Facebook -->
  <meta property="og:title" content="Solergy Solutions SARL - Vente et Installation d'Équipements Solaires à Douala, Cameroun">
  <meta property="og:description" content="Votre spécialiste en solutions solaires, de la vente à l'installation d'équipements solaires à Douala, Cameroun.">
  <meta property="og:image" content="{{ asset('logo.jpg') }}">
  <meta property="og:url" content="https://www.solergy-solutions.com/">
  <meta property="og:type" content="website">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Solergy Solutions SARL - Vente et Installation d'Équipements Solaires à Douala, Cameroun">
  <meta name="twitter:description" content="Découvrez nos solutions solaires innovantes pour vos projets d'énergie renouvelable à Douala.">
  <meta name="twitter:image" content="{{ asset('logo.jpg') }}">

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

  <!-- Icon Font Stylesheet -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Libraries Stylesheet -->
  <link href="{{ asset('frontend-assets/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend-assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

  <!-- Bootstrap & Template Stylesheet -->
  <link href="{{ asset('frontend-assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend-assets/css/style.css') }}" rel="stylesheet">

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="../favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../favicon/favicon-16x16.png">
  <link rel="manifest" href="../favicon/site.webmanifest">
  <meta name="theme-color" content="#ffffff">

  <!-- AOS CSS pour les animations -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

  <!-- GSAP Core -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Draggable.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollSmoother.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/CustomEase.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/CustomBounce.min.js"></script>
  @livewireStyles

  <!-- Structured Data (JSON-LD) pour le SEO -->
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Solergy Solutions SARL",
      "url": "https://www.solergy-solutions.com/",
      "logo": "{{ asset('logo.jpg') }}",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+237657248925",
        "contactType": "customer support",
        "areaServed": "CM",
        "availableLanguage": "fr"
      },
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "En face Collège Bénédicte, Ndockoti",
        "addressLocality": "Douala",
        "addressCountry": "CM"
      },
      "sameAs": [
        "https://www.facebook.com/solergysolutions",
        "https://twitter.com/solergysolutions",
        "https://www.linkedin.com/company/solergysolutions"
      ]
    }
  </script>

  <style>
    /* Transitions et animations personnalisées */
    .hero-header {
      transition: all 0.5s ease;
      min-height: 80vh;
    }

    .hero-header:hover {
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .search-btn {
      transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .search-btn:hover {
      background-color: #ff7f00;
      transform: translateY(-2px);
    }

    .carousel.slide {
      transition: transform 0.4s ease;
    }

    .carousel.slide:hover {
      transform: scale(1.02);
    }

    .featurs-item {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .featurs-item:hover {
      transform: translateY(-5px) scale(1.03);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .featurs-icon {
      transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .featurs-item:hover .featurs-icon {
      background-color: #ff7f00;
      transform: rotate(10deg);
    }
    /* Icône WhatsApp flottante */
.whatsapp-float-orange {
  position: fixed;
  bottom: 6rem;
  right: 2rem;
  background-color:rgb(181, 78, 9);
  color: #fff;
  width: 4.5rem;
  height: 4.5rem;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
  z-index: 1000;
  cursor: pointer;
  /* prépare l’animation GSAP, mais pour un fallback CSS */
  animation: whatsapp-bounce-css 2s infinite;
  transition: transform 0.3s ease, box-shadow 0.3s ease;

  overflow: hidden;
  position: fixed;
}
.whatsapp-float-orange:hover {
  transform: scale(1.2) rotate(10deg);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
}

/* Fallback CSS bounce si GSAP non chargé */
@keyframes whatsapp-bounce-css {
  0%, 100%   { transform: translateY(0); }
  50%        { transform: translateY(-10px); }
}

  </style>

<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '681776711126337');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=681776711126337&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
</head>

<body>
  <!-- Spinner de chargement -->
  <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" role="status"></div>
  </div>

  <!-- Navbar (Header) -->
  <header>
    <livewire:front-end-header-view />
  </header>

  <!-- Acceuill -->
  <section class="hero-header position-relative " style="background-image: url('<?php echo asset('home2.png'); ?>')" data-aos="fade-up">
    <livewire:front-end-acceuil-view />
  </section>

  <!-- Section Features -->


  <!-- Section Produits en Promotion -->
  <section class="py-2 consumption-card p-4 mb-4">
    <div class="container-fluid ">
      <livewire:front-end-promo-product>
    </div>
  </section>

    <!-- Section Services -->
  <section class="service py-5">
    <div class="container-fluid">
      <livewire:front-end-service-view>
    </div>
  </section>

  <!-- Section produits -->
  <section class="service py-5">
    <div class="container-fluid">
      <livewire:front-end-nos-produit-view>
    </div>
  </section>

  <!-- Section Réalisations / Projets -->
  <section class="service py-5">
    <div class="container-fluid">
      <livewire:front-end-realisation-view />
    </div>
  </section>

  <!-- Section Catégories de Produits -->
  <section>
    <livewire:front-end-categori-product-view>
  </section>

  <!-- Garantie -->
  <section class="featurs py-5">
    <div class="container py-5">
      <div class="row g-4">
        <!-- Feature 1 : Installation Rapide -->
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
          <div class="featurs-item text-center rounded bg-light p-4">
            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-4 mx-auto">
              <i class="fas fa-solar-panel fa-3x text-white"></i>
            </div>
            <h5>Installation Rapide</h5>
            <p class="mb-0">Installation en moins de 24h</p>
          </div>
        </div>
        <!-- Feature 2 : Énergie Efficace -->
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
          <div class="featurs-item text-center rounded bg-light p-4">
            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-4 mx-auto">
              <i class="fas fa-bolt fa-3x text-white"></i>
            </div>
            <h5>Énergie Efficace</h5>
            <p class="mb-0">Optimisation de l’énergie solaire</p>
          </div>
        </div>
        <!-- Feature 3 : Sécurité Garantie -->
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
          <div class="featurs-item text-center rounded bg-light p-4">
            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-4 mx-auto">
              <i class="fas fa-shield-alt fa-3x text-white"></i>
            </div>
            <h5>Sécurité Garantie</h5>
            <p class="mb-0">Matériel de qualité et garanti</p>
          </div>
        </div>
        <!-- Feature 4 : Support 24/7 -->
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
          <div class="featurs-item text-center rounded bg-light p-4">
            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-4 mx-auto">
              <i class="fa fa-headset fa-3x text-white"></i>
            </div>
            <h5>Support 24/7</h5>
            <p class="mb-0">Assistance technique continue</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section annonce -->
  <section class="service py-5">
    <div class="container-fluid">
      <livewire:front-end-annonce-view />
    </div>
  </section>

  <!-- Footer -->
<footer class="bg-dark text-light pt-5 mt-5" id="contact">
  <div class="container">

    <!-- Newsletter & Logo -->
    <div class="row align-items-center mb-5">
      <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
        <a href="#" class="text-decoration-none">
          <h2 class="text-warning mb-1">Solergy Solutions SARL</h2>
          <p class="small">Votre expert en énergie solaire à Douala</p>
        </a>
      </div>
      <div class="col-md-8">
        <form class="row g-2 justify-content-center justify-content-md-end">
          <div class="col-auto flex-grow-1">
            <label for="footer-email" class="visually-hidden">Votre Email</label>
            <input id="footer-email" type="email" class="form-control rounded-pill" placeholder="Entrez votre email">
          </div>
          <div class="col-auto">
            <button type="submit" class="btn btn-warning rounded-pill px-4">S’abonner</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Liens utiles & Contact -->
    <div class="row gy-4">
      <!-- Pourquoi nous choisir -->
      <div class="col-lg-3 col-md-6">
        <h5 class="text-warning mb-3">Pourquoi nous choisir ?</h5>
        <p>Une équipe certifiée, des solutions sur-mesure et un support 24/7 pour vos installations solaires.</p>
        <a href="#" class="btn btn-outline-light btn-sm rounded-pill mt-2">En savoir plus</a>
      </div>

      <!-- Produits & Services -->
      <div class="col-lg-3 col-md-6">
        <h5 class="text-warning mb-3">Nos offres</h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-light text-decoration-none">Panneaux photovoltaïques</a></li>
          <li><a href="#" class="text-light text-decoration-none">Batteries de stockage</a></li>
          <li><a href="#" class="text-light text-decoration-none">Inverters & Regulators</a></li>
          <li><a href="#" class="text-light text-decoration-none">Entretien & SAV</a></li>
        </ul>
      </div>

      <!-- À propos -->
      <div class="col-lg-3 col-md-6">
        <h5 class="text-warning mb-3">À propos</h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-light text-decoration-none">Qui sommes-nous ?</a></li>
          <li><a href="#" class="text-light text-decoration-none">Nos réalisations</a></li>
          <li><a href="#" class="text-light text-decoration-none">Blog & conseils</a></li>
          <li><a href="#" class="text-light text-decoration-none">Carrières</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="col-lg-3 col-md-6">
        <h5 class="text-warning mb-3">Contact</h5>
        <ul class="list-unstyled small">
          <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>Ndockoti, Douala, Cameroun</li>
          <li class="mb-2"><i class="fas fa-phone me-2"></i>+237 6 57 24 89 25</li>
          <li class="mb-2"><i class="fas fa-envelope me-2"></i><a href="mailto:solergysolutions@gmail.com" class="text-light">solergysolutions@gmail.com</a></li>
        </ul>
        <div>
          <a href="#" class="btn btn-outline-light btn-sm rounded-circle me-2"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="btn btn-outline-light btn-sm rounded-circle me-2"><i class="fab fa-twitter"></i></a>
          <a href="#" class="btn btn-outline-light btn-sm rounded-circle me-2"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" class="btn btn-outline-light btn-sm rounded-circle"><i class="fab fa-whatsapp"></i></a>
        </div>
      </div>
    </div>

    <!-- Bas de page -->
    <div class="row mt-5 pt-4 border-top border-secondary">
      <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
        <small>&copy; 2025 Solergy Solutions SARL. Tous droits réservés.</small>
      </div>
      <div class="col-md-6 text-center text-md-end">
        <small>Design par <a href="mailto:anoudemj@gmail.com" class="text-warning text-decoration-none">anoudemj@gmail.com</a></small>
      </div>
    </div>

  </div>
</footer>

  
  <!-- Floating WhatsApp Button -->
  <a href="https://wa.me/237657248925" style="height: 50px; width: 50px; color:#ff7f00" target="_blank" class="whatsapp-float-orange" aria-label="Contactez-nous sur WhatsApp">
    <i class="bi bi-whatsapp"></i>
  </a>
  

  <!-- Back to Top -->
  <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

  @livewireScripts
  <!-- JavaScript Libraries -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('frontend-assets/lib/easing/easing.min.js') }}"></script>
  <script src="{{ asset('frontend-assets/lib/waypoints/waypoints.min.js') }}"></script>
  <script src="{{ asset('frontend-assets/lib/lightbox/js/lightbox.min.js') }}"></script>
  <script src="{{ asset('frontend-assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
  <!-- Template Javascript -->
  <script src="{{ asset('frontend-assets/js/main.js') }}"></script>
  <!-- AOS Script -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
      once: true,
      offset: 100,
      duration: 800
    });
  </script>
  <script>
  // Sélection de l’icône
  const waBtn = document.querySelector('.whatsapp-float');

  // Bounce vertical infini
  gsap.to(waBtn, {
    y: -15,
    repeat: -1,
    yoyo: true,
    ease: "power1.inOut",
    duration: 0.6
  });

  // Petite rotation oscillante
  gsap.to(waBtn, {
    rotation: 15,
    repeat: -1,
    yoyo: true,
    ease: "power1.inOut",
    duration: 1.2,
    delay: 0.3
  });

  // Survol : pulse rapide
  waBtn.addEventListener('mouseenter', () => {
    gsap.to(waBtn, { scale: 1.3, duration: 0.3, ease: "elastic.out(1, 0.5)" });
  });
  waBtn.addEventListener('mouseleave', () => {
    gsap.to(waBtn, { scale: 1, duration: 0.3, ease: "power2.out" });
  });
</script>

</body>

</html>