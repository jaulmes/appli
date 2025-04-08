<!-- Logo et nom de l'application -->
<a href="#" class="brand-link">
  <img src="../logo.jpg" alt="Solergy Solutions" class="brand-image img-circle elevation-3" style="opacity: .8">
  <span class="brand-text font-weight-light">Solergy Solutions</span>
</a>

<!-- Sidebar principale -->

  <!-- Contenu de la sidebar -->
  <div class="sidebar">
    <!-- Panneau utilisateur (si connecté) -->
    @auth
    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
      <div class="image">
        <!-- Image utilisateur par défaut (à adapter si besoin) -->
        <img src="{{ asset('path/to/default-user.png') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="{{ url('users/edit', [Auth::User()->id]) }}" class="d-block">{{ Auth::User()->name }}</a>
      </div>
    </div>
    @endauth

    <!-- Menu de navigation de la sidebar -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <!-- Boutique -->
        <li class="nav-item">
          <a href="{{ route('panier.index') }}" class="nav-link {{ Request::is('panier/index*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
              <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
            <p>Boutique</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('panier.proformat') }}" class="nav-link {{ Request::is('panier/proformat*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
              <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
            <p>Faire des proformats</p>
          </a>
        </li>

        <!-- Dashboard (pour les utilisateurs autorisés) -->
        @can('VOIR_CHARGE')
        <li class="nav-item">
          <a href="{{ route('dashboard.index') }}" wire:navigate class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-speedometer2"></i>
            <p>Dashboard</p>
          </a>
        </li>
        @endcan

        <!-- Tâches -->
        <li class="nav-item">
          <a href="{{ route('taches.index') }}" wire:navigate class="nav-link {{ Request::is('taches/index*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-list-task"></i>
            <p>Tâches</p>
          </a>
        </li>

        <!-- Factures et Reçus -->
        <li class="nav-item has-treeview {{ Request::is('factures*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ Request::is('factures*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-receipt"></i>
            <p>
              Factures et Reçus
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('factures.ventes') }}"  class="nav-link {{ Request::is('factures/ventes*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Factures</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('recus.index') }}"  class="nav-link {{ Request::is('factures/recus*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Reçus
                  <span class="badge badge-danger right">New</span>
                </p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Produits -->
        @can('VOIR_PRODUIT')
        <li class="nav-item has-treeview {{ Request::is('produit*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ Request::is('produit*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-box-fill"></i>
            <p>
              Produits
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('produit.index') }}" wire:navigate class="nav-link {{ Request::is('produit/index*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Liste des produits</p>
              </a>
            </li>
            @can('CREER_PRODUIT')
            <li class="nav-item">
              <a href="{{ route('produit.ajouter') }}"  class="nav-link {{ Request::is('produit/create*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Ajouter</p>
              </a>
            </li>
            @endcan
            <li class="nav-item">
              <a href="{{ route('produit.categori') }}" wire:navigate class="nav-link {{ Request::is('produit/categori*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Liste des catégories</p>
              </a>
            </li>
            @can('CREER_PRODUIT')
            <li class="nav-item">
              <a href="{{ route('produit.ajouter_categori') }}" wire:navigate class="nav-link {{ Request::is('produit/ajouter_categori*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Ajouter une catégorie</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('produit.afficherFournisseur') }}" wire:navigate class="nav-link {{ Request::is('produit/categori*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Liste des fournisseurs</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('produit.ajouterFournisseur') }}" wire:navigate class="nav-link {{ Request::is('produit/ajouter_categori*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Ajouter un fournisseur</p>
              </a>
            </li>
            @endcan
          </ul>
        </li>
        @endcan

        <!-- Ventes & Installations -->
        @can('VOIR_VENTE')
          @can('VOIR_ACHAT')
            <li class="nav-item">
              <a href="{{ route('ventes.index') }}" wire:navigate class="nav-link {{ Request::is('ventes/index*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-funnel"></i>
                <p>Ventes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('installations.index') }}" wire:navigate class="nav-link {{ Request::is('installations/index*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-plugin"></i>
                <p>Installations</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('ventes.index') }}" wire:navigate class="nav-link {{ Request::is('ventes/index*') ? 'active' : '' }}">
              📦
                <p>Commandes</p>
              </a>
            </li>
          @endcan
        @endcan

        <!-- Approvisionnement -->
        @can('VOIR_ACHAT')
        <li class="nav-item has-treeview {{ Request::is('achats*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ Request::is('achats*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-basket"></i>
            <p>
              Approvisionnement
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('achats.index') }}" wire:navigate class="nav-link {{ Request::is('achats/index*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Afficher les achats</p>
              </a>
            </li>
            @can('CREER_ACHAT')
            <li class="nav-item">
              <a href="{{ route('achats.cart') }}" class="nav-link {{ Request::is('achats/cart*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Créer un achat</p>
              </a>
            </li>
            @endcan
          </ul>
        </li>
        @endcan

        <!-- Journal des transactions -->
        <li class="nav-item has-treeview {{ Request::is('transactions*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ Request::is('transactions*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-activity"></i>
            <p>
              Journal
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @can('VOIR_TRANSACTION')
            <li class="nav-item">
              <a href="{{ route('transaction.index') }}" wire:navigate class="nav-link {{ Request::is('transactions/index*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Toutes les activités</p>
              </a>
            </li>
            @endcan
            <li class="nav-item">
              <a href="{{ route('transaction.mesTransactions') }}" wire:navigate class="nav-link {{ Request::is('transactions/mesTransactions*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Mes activités</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Charges -->
        @can('VOIR_CHARGE')
        <li class="nav-item has-treeview {{ Request::is('charges*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ Request::is('charges*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Charges
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('charges.index') }}" wire:navigate class="nav-link {{ Request::is('charges/index*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Afficher les charges</p>
              </a>
            </li>
            @can('CREER_CHARGE')
            <li class="nav-item">
              <a href="{{ route('charges.create') }}" wire:navigate class="nav-link {{ Request::is('charges/create*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Créer une charge</p>
              </a>
            </li>
            @endcan
          </ul>
        </li>
        @endcan

        <!-- Sécurité : Permissions -->
        @can('VOIR_PERMISSION')
        <li class="nav-item has-treeview {{ Request::is('securite/permission*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ Request::is('securite/permission*') ? 'active' : '' }}">
            <i class="nav-icon fa fa-lock"></i>
            <p>
              Permissions
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('permission.index') }}" wire:navigate class="nav-link {{ Request::is('securite/permission/index*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Liste des permissions</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('permission.create') }}" wire:navigate class="nav-link {{ Request::is('securite/permission/create*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Créer une permission</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{ route('frontend.admin') }}" wire:navigate class="nav-link {{ Request::is('frontend*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-speedometer2"></i>
            <p>Site Web Admin</p>
          </a>
        </li>
        @endcan

        <!-- Sécurité : Rôles -->
        @can('VOIR_ROLE')
        <li class="nav-item has-treeview {{ Request::is('securite/role*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ Request::is('securite/role*') ? 'active' : '' }}">
            <i class="nav-icon fa fa-lock"></i>
            <p>
              Rôles
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('role.index') }}" wire:navigate class="nav-link {{ Request::is('securite/role/index*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Liste des rôles</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('role.create') }}" wire:navigate class="nav-link {{ Request::is('securite/role/create*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Créer un rôle</p>
              </a>
            </li>
          </ul>
        </li>
        @endcan

        <!-- Utilisateurs -->
        @can('VOIR_UTILISATEURS')
        <li class="nav-item has-treeview {{ Request::is('users*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
            <i class="nav-icon fa fa-user"></i>
            <p>
              Utilisateurs
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('users.index') }}" wire:navigate class="nav-link {{ Request::is('users/index*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Liste des utilisateurs</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('users.create') }}" wire:navigate class="nav-link {{ Request::is('users/create*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Créer un utilisateur</p>
              </a>
            </li>
          </ul>
        </li>
        @endcan

        <!-- Section IMPOT -->
        @can('IMPOT')
        <li class="nav-header">IP</li>
        <li class="nav-item has-treeview {{ Request::is('produit*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ Request::is('produit*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              Produits
              <i class="right fas fa-angle-left"></i>
              <span class="badge badge-info right">6</span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('produit.index') }}" class="nav-link {{ Request::is('produit/index*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Liste des produits</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('produit.ajouter') }}" class="nav-link {{ Request::is('produit/create*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Ajouter</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('produit.categori') }}" class="nav-link {{ Request::is('produit/categori*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Liste des catégories</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('produit.ajouter_categori') }}" class="nav-link {{ Request::is('produit/ajouter_categori*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Ajouter une catégorie</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview {{ Request::is('ventes*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ Request::is('ventes*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Ventes
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('ventes.impot') }}" class="nav-link {{ Request::is('ventes/impot*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Ventes</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview {{ Request::is('achats*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ Request::is('achats*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Approvisionnement
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('achats.impot') }}" class="nav-link {{ Request::is('achats/impot*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Afficher les Achats</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('achats.cart') }}" class="nav-link {{ Request::is('achats/cart*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Créer un achat</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview {{ Request::is('charges*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ Request::is('charges*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Charges
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('charges.index') }}" class="nav-link {{ Request::is('charges/index*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Afficher les charges</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('charges.create') }}" class="nav-link {{ Request::is('charges/create*') ? 'active' : '' }}">
                <i class="nav-icon far fa-circle"></i>
                <p>Créer une charge</p>
              </a>
            </li>
          </ul>
        </li>
        @endcan

      </ul>
    </nav>
    <!-- Fin du menu -->
  </div>
  <!-- /.sidebar -->

