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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
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

        <!-- Copyright Start -->
        <div class="container-fluid copyright bg-dark py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Your Site Name</a>, All right reserved.</span>
                    </div>
                    <div class="col-md-6 my-auto text-center text-md-end text-white">
                        <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                        <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                        <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                        Designed By <a class="border-bottom" href="#">anoudemj@gmail.com</a> Distributed By <a class="border-bottom" href="https://themewagon.com">ThemeWagon</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->



        <!-- Back to Top -->
        <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
    <!-- JavaScript Libraries -->

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