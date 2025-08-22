<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Solergy solutions - solution energetique et autonome</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

  <!-- Icon Font Stylesheet -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Libraries Stylesheet -->
  <link href="{{asset('frontend-assets/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">
  <link href="{{ asset('frontend-assets/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">


  <!-- Customized Bootstrap Stylesheet -->
  <link href="{{asset('frontend-assets/css/bootstrap.min.css')}}" rel="stylesheet">

  <!-- Template Stylesheet -->
  <link href="{{ asset('frontend-assets/css/style.css')}}" rel="stylesheet">

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="../favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../favicon/favicon-16x16.png">
  <link rel="manifest" href="../favicon/site.webmanifest">
  <meta name="theme-color" content="#ffffff">
  @livewireStyles
  <style>
    /* Nouveau bouton WhatsApp jaune */
      .whatsapp-float-yellow {
        position: fixed;
        bottom: 7.5rem;      /* légèrement au-dessus de l’orange (orange est à 6rem) */
        right: 2rem;
        background-color:rgb(244, 233, 28); /* jaune Bootstrap */
        color: #fff;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        cursor: pointer;
        animation: whatsapp-bounce-css 2s infinite;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
      }
      .whatsapp-float-yellow:hover {
        transform: scale(1.2) rotate(10deg);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
      }

          /* Icône WhatsApp orange */
      .whatsapp-float-orange {
        position: fixed;
        bottom: 4.4rem;
        right: 2rem;
        background-color:rgb(236, 100, 10);
        color: #fff;
        width: 2.5rem;
        height: 2.5rem;
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
    ! function(f, b, e, v, n, t, s) {
      if (f.fbq) return;
      n = f.fbq = function() {
        n.callMethod ?
          n.callMethod.apply(n, arguments) : n.queue.push(arguments)
      };
      if (!f._fbq) f._fbq = n;
      n.push = n;
      n.loaded = !0;
      n.version = '2.0';
      n.queue = [];
      t = b.createElement(e);
      t.async = !0;
      t.src = v;
      s = b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
      'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '9916049995153025');
    fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=9916049995153025&ev=PageView&noscript=1" /></noscript>
  <!-- End Meta Pixel Code -->
  @yield('head')
</head>

<body>

  <!-- Spinner Start -->
  <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" role="status"></div>
  </div>
  <!-- Spinner End -->


  <!-- Navbar start -->
  @include('frontend.layout.navbar')
  <!-- Navbar End -->


  <!-- Home -->

  @yield('home')
  <!-- Home end -->


  <!-- Produit en promotion-->
  @yield('content')
  <!-- Tastimonial End -->


  <!-- Footer -->
  <footer class="bg-dark text-light pt-5 mt-5" id="contact">
    <div class="container">

      <!-- Newsletter & Logo -->
      <div class="row align-items-center mb-5">
        <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
          <a href="#" class="text-decoration-none">
            <h2 class="text-warning mb-1">Solergy Solutions SARL</h2>
            <p class="small">Fournisseur de solutions solaire au cameroun</p>
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

  <!-- Floating WhatsApp Button – Jaune -->
  <a href="https://wa.me/237678645111"
    class="whatsapp-float-yellow"
    target="_blank"
    aria-label="Contactez-nous sur WhatsApp (jaune)">
    <i class="bi bi-whatsapp"></i>
  </a>

  <!-- Floating WhatsApp Button – Orange -->
  <a href="https://wa.me/237657248925"
    class="whatsapp-float-orange"
    target="_blank"
    aria-label="Contactez-nous sur WhatsApp (orange)">
    <i class="bi bi-whatsapp"></i>
  </a>




  <!-- Back to Top -->
  <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


  <!-- JavaScript Libraries -->
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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('frontend-assets/lib/easing/easing.min.js')}}"></script>
  <script src="{{ asset('frontend-assets/lib/waypoints/waypoints.min.js')}}"></script>
  <script src="{{ asset('frontend-assets/lib/lightbox/js/lightbox.min.js')}}"></script>
  <script src="{{ asset('frontend-assets/lib/owlcarousel/owl.carousel.min.js')}}"></script>

  <!-- Template Javascript -->
  <script src="{{ asset('frontend-assets/js/main.js')}}"></script>
  @livewireScripts
</body>

</html>