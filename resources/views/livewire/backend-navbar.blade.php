<div>
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
                        🛒
                        <p>Boutique</p>
                    </a>
                </li>
                <!-- proformat -->
                <li class="nav-item">
                    <a href="{{ route('panier.proformat') }}" class="nav-link {{ Request::is('panier/proformat*') ? 'active' : '' }}">
                        🛒
                        <p>Faire des proformats</p>
                    </a>
                </li>
                <!-- bon de commande -->
                <li class="nav-item">
                    <a href="{{ route('bonCommandes.index') }}" class="nav-link {{ Request::is('bonCommandes/index*') ? 'active' : '' }}">
                        🛒
                        <p>Bon de Commandes</p>
                    </a>
                </li>
                <!-- packs produits -->
                <li class="nav-item has-treeview {{ Request::is('panier/pack*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('panier/pack*') ? 'active' : '' }}"> 
                        📦 
                        <p>
                            Pack produit
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="{{ route('panier.pack.create') }}" class="nav-link {{ Request::is('panier/pack/create*') ? 'active' : '' }}">
                                🛒
                                <p>Creer un pack produit</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('panier.pack.show') }}" class="nav-link {{ Request::is('panier/pack/show*') ? 'active' : '' }}">
                                🧺
                                <p>
                                    Liste des packs Produits
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Dashboard (pour les utilisateurs autorisés) -->
                @can('VOIR_CHARGE')
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"  class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}">
                        📊
                        <p>Dashboard</p>
                    </a>
                </li>
                @endcan

                <!-- Clients -->
                <li class="nav-item">
                    <a href="{{ route('clients.index') }}"  class="nav-link {{ Request::is('clients/index*') ? 'active' : '' }}">
                        👤
                        <p>Clients</p>
                    </a>
                </li>

                <!-- Tâches -->
                <li class="nav-item">
                    <a href="{{ route('taches.index') }}"  class="nav-link {{ Request::is('taches/index*') ? 'active' : '' }}">
                        📋
                        <p>Tâches</p>
                    </a>
                </li>

                <!-- Factures et Reçus -->
                <li class="nav-item has-treeview {{ Request::is('factures*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('factures*') ? 'active' : '' }}">
                        🧾
                        <p>
                            Factures et Reçus
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('factures.ventes') }}" class="nav-link {{ Request::is('factures/ventes*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Factures</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('recus.index') }}" class="nav-link {{ Request::is('factures/recus*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Reçus
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Produits -->
                @can('VOIR_PRODUIT')
                <li class="nav-item has-treeview {{ Request::is('produit*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('produit*') ? 'active' : '' }}">
                        🗃️
                        <p>
                            Produits
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('produit.index') }}" class="nav-link {{ Request::is('produit/index*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Liste des produits</p>
                            </a>
                        </li>
                        @can('CREER_PRODUIT')
                        <li class="nav-item">
                            <a href="{{ route('produit.ajouter') }}" class="nav-link {{ Request::is('produit/create*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ajouter</p>
                            </a>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('produit.categori') }}"  class="nav-link {{ Request::is('produit/categori*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Liste des catégories</p>
                            </a>
                        </li>
                        @can('CREER_PRODUIT')
                        <li class="nav-item">
                            <a href="{{ route('produit.ajouter_categori') }}"  class="nav-link {{ Request::is('produit/ajouter_categori*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ajouter une catégorie</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('produit.afficherFournisseur') }}"  class="nav-link {{ Request::is('produit/categori*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Liste des fournisseurs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('produit.ajouterFournisseur') }}"  class="nav-link {{ Request::is('produit/ajouter_categori*') ? 'active' : '' }}">
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
                        <a href="{{ route('ventes.index') }}"  class="nav-link {{ Request::is('ventes/index*') ? 'active' : '' }}">
                            💰
                            <p>Ventes</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('installations.index') }}"  class="nav-link {{ Request::is('installations/index*') ? 'active' : '' }}">
                            🛠️
                            <p>Installations</p>
                        </a>
                    </li>


                    <!-- Factures et Reçus -->
                    <li class="nav-item has-treeview {{ Request::is('commandes*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('commandes*') ? 'active' : '' }}">
                            📦
                            <p>Commandes </p>
                            <span class="badge badge-danger"> {{ $nombreCommandesNonLue}}</span>
                            <i class="right fas fa-angle-left"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            @foreach($commandesNonLue as $commande)
                            <li class="nav-item" >
                                <a href="{{ route('commandes.detail', $commande->id) }}"
                                    class="nav-link {{ request()->is('commandes/'.$commande->id) ? 'active' : '' }}" >
                                    <i class="fas fa-shopping-cart nav-icon"></i>
                                    <p>
                                        Commande #{{ $commande->id }}
                                        <span class="badge badge-danger ml-2">new</span>
                                    </p>
                                </a>
                            </li>
                            @endforeach
                            <li class="nav-item">
                                <a href="{{ route('commandes.index') }}"  class="nav-link {{ Request::is('commandes/index*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Toutes les commandes</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endcan
                @endcan

                <!-- Approvisionnement -->
                @can('VOIR_ACHAT')
                    <li class="nav-item has-treeview {{ Request::is('achats*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('achats*') ? 'active' : '' }}">
                            🚚
                            <p>
                                Approvisionnement
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('achats.index') }}"  class="nav-link {{ Request::is('achats/index*') ? 'active' : '' }}">
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
                    <li class="nav-item">
                        <a href="{{ route('simulation-all') }}"  class="nav-link {{ Request::is('simulation/index*') ? 'active' : '' }}">
                            <i class="bi bi-calculator"></i>
                            <p>Afficher les simulations</p>
                        </a>
                    </li>
                @endcan

                <!-- Journal des transactions -->
                <li class="nav-item has-treeview {{ Request::is('transactions*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('transactions*') ? 'active' : '' }}">
                        ⏳
                        <p>
                            Journal
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('VOIR_TRANSACTION')
                        <li class="nav-item">
                            <a href="{{ route('transaction.index') }}"  class="nav-link {{ Request::is('transactions/index*') ? 'active' : '' }}">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Toutes les activités</p>
                            </a>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('transaction.mesTransactions') }}"  class="nav-link {{ Request::is('transactions/mesTransactions*') ? 'active' : '' }}">
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
                        💸
                        <p>
                            Charges
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('charges.index') }}"  class="nav-link {{ Request::is('charges/index*') ? 'active' : '' }}">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Afficher les charges</p>
                            </a>
                        </li>
                        @can('CREER_CHARGE')
                        <li class="nav-item">
                            <a href="{{ route('charges.create') }}"  class="nav-link {{ Request::is('charges/create*') ? 'active' : '' }}">
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
                <li class="nav-item">
                    <a href="{{ route('frontend.admin') }}"  class="nav-link {{ Request::is('frontend*') ? 'active' : '' }}">
                        🌐
                        <p>Site Web Admin</p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{ Request::is('securite/permission*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('securite/permission*') ? 'active' : '' }}">
                        ⚙️
                        <p>
                            Permissions
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('permission.index') }}"  class="nav-link {{ Request::is('securite/permission/index*') ? 'active' : '' }}">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Liste des permissions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('permission.create') }}"  class="nav-link {{ Request::is('securite/permission/create*') ? 'active' : '' }}">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Créer une permission</p>
                            </a>
                        </li>
                    </ul>
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
                            <a href="{{ route('role.index') }}"  class="nav-link {{ Request::is('securite/role/index*') ? 'active' : '' }}">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Liste des rôles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('role.create') }}"  class="nav-link {{ Request::is('securite/role/create*') ? 'active' : '' }}">
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
                            <a href="{{ route('users.index') }}"  class="nav-link {{ Request::is('users/index*') ? 'active' : '' }}">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Liste des utilisateurs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.create') }}"  class="nav-link {{ Request::is('users/create*') ? 'active' : '' }}">
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


</div>