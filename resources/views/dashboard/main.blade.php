<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @yield("extra-meta")
  <title>Solergy Solutions</title>
  
  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="../favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../favicon/favicon-16x16.png">
  <link rel="manifest" href="../favicon/site.webmanifest">
  <meta name="theme-color" content="#ffffff">
  
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  
  @yield('head')
  @livewireStyles
</head>
<style>
  body {
    padding-top: 56px; /* Ajustez cette valeur selon la hauteur de votre navbar */
  }
</style>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light bg-white shadow-sm fixed-top">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item">
          <a href="{{ route('panier.index') }}" class="nav-link">Accueil</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">
              <i class="bi bi-power"></i> Déconnexion
            </button>
          </form>
        </li>
        <livewire:notification-component wire:click="markReadNotification()" />
      </ul>
      <!--defilement des messages notifications-->
      
    </nav>

    <!-- /.navbar -->

    <!-- /.navbar -->

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      @include('dashboard.sidebar')
    </aside>
    
    <!-- /.sidebar -->

    <!-- Content Wrapper -->
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
              <livewire:notification/>
          @yield('content')
        </div>
      </section>
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    <footer class="main-footer text-center bg-light py-3">
      <strong>&copy; 2025 Solergy Solutions. Tous droits réservés.</strong>
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
      </div>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- JS Libraries -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../plugins/select2/js/select2.full.min.js"></script>
  <script src="../../dist/js/adminlte.min.js"></script>
  
  <!-- Scripts -->
  <script>
    $(function () {
      $('.select2').select2({
        theme: 'bootstrap4'
      });
    });

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  </script>

  @yield('javascript')
  @livewireScripts
</body>
</html>
