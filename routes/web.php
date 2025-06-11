<?php

use App\Http\Controllers\AchatController;
use App\Http\Controllers\BonCommandeController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\PrivilageController;
use App\Http\Controllers\ChargeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\ComptabiliteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\InstallationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\produitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecusController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\VentesController;
use App\Http\Controllers\UserController;
use App\Livewire\FrontEndCategoriDetailView;
use App\Models\Installation;
use Illuminate\Support\Facades\Route;
use App\Models\Produit;
use Barryvdh\DomPDF\Facade\Pdf;
use Darryldecode\Cart\Cart;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/welcome', function(){
    $pdf = Pdf::loadView('welcome');
    return $pdf->stream('facture.pdf');
    //return view('welcome');
});

Route::get('/test', function(){
    return view('test');
    //return view('welcome');
});

Route::match(['get', 'post'], '/vider', function(){
    session()->forget('parnier_pack');
});

Route::get('/', [FrontEndController::class, 'index'])->name('frontend.index');
Route::get('allPromoProduit', [FrontEndController::class, 'allPromoProduit'])->name('allPromoProduit');

Route::get('all-produit', [FrontEndController::class, 'allProduits'])->name('all-produit');

Route::get('all-realisations', [FrontEndController::class, 'allRealisations'])->name('all-realisations');
Route::get('nos-services', [FrontEndController::class, 'nosServices'])->name('nos-services');

Route::get('produit-detail/{id}', [FrontEndController::class, 'detailProduit'])->name('produit-detail');
Route::post('add-to-cart/{id}', [FrontEndController::class, 'addToCart'])->name('add-to-cart');

Route::get('allCategorie', [FrontEndController::class, 'allCategories'])->name('all-categorie');
Route::get('categorie-detail/{id}', [FrontEndController::class, 'categorieDetail'])->name('categorie-detail');

Route::get('detail-realisation/{id}', [FrontEndController::class, 'detailRealisation'])->name('detail-realisation');

Route::get('detail-service/{id}', [FrontEndController::class, 'detailService'])->name('detail-service');

Route::get('passer-commande', [FrontEndController::class, 'passerCommande'])->name('passer.commande');
Route::post('valider-commande', [FrontEndController::class, 'validerCommande'])->name('valider.commande');
Route::get('afficher-commande/{id}', [FrontEndController::class, 'afficherFactureComande'])->name('afficher.commande');
Route::get('telecharger-commande/{id}', [FrontEndController::class, 'telechargerFactureComande'])->name('telecharger.commande');

Route::get('detail-pack/{id}', [FrontEndController::class, 'detailPack'])->name('detail-pack');
Route::get('all-pack', [FrontEndController::class, 'allPack'])->name('all-pack');
Route::post('add-pack-to-cart/{id}', [FrontEndController::class, 'addPackToCart'])->name('add-pack-to-cart');
Route::get('simulateur', [FrontEndController::class, 'simulateur'])->name('simulateur');


Route::get('api', [App\Http\Controllers\CallMomoApiController::class, 'index']);
Route::get('apiUser/form', [App\Http\Controllers\CallMomoApiController::class, 'apiUserForm'])->name('apiUser.form');//show form for user api
Route::post('apiUser', [App\Http\Controllers\CallMomoApiController::class, 'apiUser'])->name('apiUser.get');//create user api
Route::get('apiUser/info', [App\Http\Controllers\CallMomoApiController::class, 'userInfo'])->name('apiUser.info');//get user api info

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //front end admin
    Route::get('/frontend/admin', [FrontEndController::class, 'admin'])->name('frontend.admin');
    Route::get('/frontend/admin/allPromoProduit', [FrontEndController::class, 'allPromoProduitAdmin'])->name('frontend.admin.allPromoProduit');
    Route::get('frontend/admin/create-annonces', [FrontEndController::class, 'createAnnonce'])->name('annonce.create');

    /**
     * simulation
     */
    Route::get('simulation/index', [SimulationController::class, 'index'])->name('simulation-all');
    Route::get('rapport/simultion/afficher/{id}', [SimulationController::class, 'rapport'])->name('rapport.simulation');

    /**
     * Dashboardd
     */
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('dashboard/comptes', [ComptabiliteController::class, 'index'])->name('dashboard.compte');
    Route::get('dashboard/comptes/ajouter', [ComptabiliteController::class, 'create'])->name('dashboard.compte.create');
    Route::post('dashboard/comptes/store', [ComptabiliteController::class, 'store'])->name('dashboard.compte.store');
    Route::get('dashboard/comptes/edit/{id}', [ComptabiliteController::class, 'edit'])->name('dashboard.compte.edit');
    Route::put('dashboard/comptes/update/{id}', [ComptabiliteController::class, 'update'])->name('dashboard.compte.update');
    Route::delete('dashboard/comptes/delete/{id}', [ComptabiliteController::class, 'delete'])->name('dashboard.compte.delete');
    //vue pour transfert compte
    Route::get('dashboard/comptes/transfert', [ComptabiliteController::class, 'transfert'])->name('dashboard.compte.transfert');
    //valider le transfert d'un compte a un autre
    Route::post('dashboard/comptes/valider_transfert', [ComptabiliteController::class, 'valider_transfert'])->name('dashboard.compte.valider_transfert');
    
    /**
     * clients
     */
    Route::get('clients/index', [ClientController::class, 'index'])->name('clients.index');

    /**
     * bon de commande
     */
    Route::get('bonCommandes/index', [BonCommandeController::class, 'index'])->name('bonCommandes.index');
    Route::get('bonCommandes/create', [BonCommandeController::class, 'create'])->name('bonCommandes.create');
    
    
    
    /**
     * produit
     */
    Route::get('/produit/index', [produitController::class, 'index'])->name('produit.index');
    Route::get('/produit/create', [produitController::class, 'create'])->name('produit.ajouter');
    Route::post('/produit/store', [produitController::class, 'store'])->name('produit.store');
    Route::get('/produit/show/{id}', [produitController::class, 'show'])->name('produit.show');
    Route::put('/produit/edit/{id}', [produitController::class, 'edit'])->name('produit.edit');
    Route::delete('/produit/delete/{id}', [produitController::class, 'destroy'])->name('produit.delete');
    
    
    //importer les produit
    Route::get('/produit/import', [produitController::class, 'importProduit'])->name('produit.import');
    Route::post('/produit/import', [produitController::class, 'storeImportProduit'])->name('produit.storeImportProduit');
    
    
    /**
     * categorie des produit
     */
    Route::get('/produit/categori', [produitController::class, 'index_categorie'])->name('produit.categori');
    Route::get('/produit/ajouter_categori', [produitController::class, 'create_categorie'])->name('produit.ajouter_categori');
    Route::post('/produit/store_categori', [produitController::class, 'store_categories'])->name('produit.store_categori');
    Route::put('/produit/edit_categori/{id}', [produitController::class, 'edit_categories'])->name('produit.edit_categori');
    Route::get('/produit/show_categori/{id}', [produitController::class, 'show_categories'])->name('produit.show_categori');
    Route::delete('/produit/delete_categori/{id}', [produitController::class, 'delete_categories'])->name('produit.delete_categories');
    
    /**
     * fournisseur de produit
     */
    Route::get('/produit/afficherFournisseurs', [FournisseurController::class, 'index'])->name('produit.afficherFournisseur');
    Route::get('/produit/ajouterFournisseur', [FournisseurController::class, 'create'])->name('produit.ajouterFournisseur');
    Route::post('/produit/storeFournisseur', [FournisseurController::class, 'store'])->name('produit.storeFournisseur');
    
    /**
     * panier
     */
    
    //catalogue pour les produits
    Route::get('panier/index', [PanierController::class, 'afficheProduit'])->name('panier.index');

    //catalogue pour les pack
    Route::get('panier/pack/create', [PanierController::class, 'createPack'])->name('panier.pack.create');
    Route::get('panier/pack/show', [PanierController::class, 'afficherPack'])->name('panier.pack.show');



    //catalogue pour les proformats
    Route::get('panier/proformat', [PanierController::class, 'proformat'])->name('panier.proformat');
    //rechercher un produit
    Route::get('/panier/search', [PanierController::class, 'search'])->name('panier.search');
    //detail du produit
    Route::get('panier/produit_detail/{id}', [PanierController::class, 'detailProduit'])->name('produit.detail');
    Route::get('panier/retirer/{id}', [PanierController::class, 'retirerProduit'])->name('produit.retirer');
    
    //ajouter un produit au panier
    Route::post('panier/ajouter', [PanierController::class, 'ajouterAuPanier'])->name('panier.ajouter');
    //afficher le panier
    Route::get('monPanier', [PanierController::class, 'index'])->name('panier.monPanier');
    
    //modifier quantite
    Route::patch('panier/{id}', [PanierController::class, 'update'])->name('panier.update');
    
    //retirer un produit du panier
    Route::delete('panier/delete/{id}', [PanierController::class, 'delete'])->name('panier.delete');
    
    //afficher la facture apres avoir realise un achat ou une vente. la route c'est facture sans "s"
    Route::get('facture', [PanierController::class, 'afficheFacture'])->name('panier.facture');
    Route::post('panier/enregistrer', [PanierController::class, 'validerVente'])->name('panier.enregistrer');
    Route::post('panier/installation', [PanierController::class, 'validerInstallation'])->name('panier.installation');
    Route::post('panier/proformat', [PanierController::class, 'validerProformat'])->name('panier.proformat');

    /**
     * facture
     */

    //afficher les factures des ventes enregistre dans le systeme
    Route::get('factures/ventes', [FactureController::class, 'factureVente'])->name('factures.ventes');
    

    //telecharger la facture d'un la vente
    Route::get('factures/ventes/telecharger/{id}', [FactureController::class, 'telechargerFactureVente'])->name('factures.ventes.telecharger');
    //afficher une facture d'un la vente
    Route::get('factures/ventes/afficher/{id}', [FactureController::class, 'afficherFactureVente'])->name('factures.ventes.afficher');
    
    //afficher les facture des installatiions enregistre dans le systeme
    Route::get('factures/installations', [FactureController::class, 'factureInstallation'])->name('factures.installations');
    //telecharger la facture d'uneinstallations installations
    Route::get('factures/installations/telecharger/{id}', [FactureController::class, 'telechargerFactureInstallation'])->name('factures.installations.telecharger');
    //afficher une facture d'une installations
    Route::get('factures/installations/afficher/{id}', [FactureController::class, 'afficherFactureInstallation'])->name('factures.installations.afficher');

    Route::get('factures/proformats/telecharger/{id}', [FactureController::class, 'telechargerFactureProformat'])->name('factures.proformats.telecharger');
    Route::get('factures/proformats/afficher/{id}', [FactureController::class, 'afficherFactureProformat'])->name('factures.proformats.afficher');
    /**
     * ventes
     */
    Route::get('ventes/index', [VentesController::class, 'index'])->name('ventes.index');
    Route::get('ventes/impot', [VentesController::class, 'ventesImpot'])->name('ventes.impot');
    Route::get('ventes/termine', [VentesController::class, 'ventesTermine'])->name('ventes.termine');
    Route::get('ventes/non-termine', [VentesController::class, 'ventesNonTermine'])->name('ventes.nonTermine');
    Route::patch('ventes/modifier/{id}', [VentesController::class, 'updateVente'])->name('ventes.modifier');
    //filtrer les ventes
    Route::get('ventes/filtrer', [VentesController::class, 'filtrerVentes'])->name('ventes.filtrer');
    Route::get('ventes/rechercher', [VentesController::class, 'rechercherVente'])->name('ventes.rechercher');

    /**
     * installations
     */
    Route::get('/installations/index', [InstallationController::class, 'index'])->name('installations.index');

    /**
     * Commandes
     */
    Route::get('commandes/index', [CommandeController::class, 'index'])->name('commandes.index');
    Route::get('commandes/{id}', [CommandeController::class, 'commandeDetail'])->name('commandes.detail');

    /**
     * recus
     */
    //crate
    Route::get('recus/create', [RecusController::class, 'create'])->name('recus.create');
    Route::post('recus/store', [RecusController::class, 'store'])->name('recus.store');
    //installation
    Route::post('installations/ajouterPaiement/{id}', [InstallationController::class, 'ajouterPaiement'])->name('installations.ajouterPaiement');
    Route::get('installations/voir/ajouterPaiement/{id}', [InstallationController::class, 'formShow'])->name('installations.voir.ajouterPaiement');

    //ventes
    
    Route::get('ventes/voir/ajouterPaiement/{id}', [VentesController::class, 'formShow'])->name('ventes.voir.ajouterPaiement');
    Route::post('ventes/ajouterPaiement/{id}', [VentesController::class, 'ajouterPaiement'])->name('ventes.ajouterPaiement');
    Route::get('factures/recus', [RecusController::class, 'index'])->name('recus.index');
    
    Route::get('factures/recus/afficher/{id}', [RecusController::class, 'afficherPdf'])->name('factures.recus.afficher');
    /**
     * Achats
     */
    Route::get('achats/index', [AchatController::class, 'index'])->name('achats.index');
    Route::get('achats/impot', [AchatController::class, 'achatsImpot'])->name('achats.impot');
    Route::get('achats/create', [AchatController::class, 'create'])->name('achats.create');
    Route::get('achat/produit', [AchatController::class, 'afficherProduitCategorise'])->name('achats.produit');

    Route::post('achats/store', [AchatController::class, 'store'])->name('achats.store');

    ///////avec cart

    Route::get('achats/cart', [AchatController::class, 'createAchat'])->name('achats.cart');

    Route::post('achats/store/cart', [AchatController::class, 'achatStoreCart'])->name('achats.storeCart');
    Route::post('achat/valider', [AchatController::class, 'validerAchat'])->name('achat.valider');

    /**
     * Roles et permission
     */

    //Permissions
    Route::get('securite/permission/index', [PrivilageController::class, 'indexPermission'])->name('permission.index');
    Route::get('securite/permission/create', [PrivilageController::class, 'createPermission'])->name('permission.create');
    Route::post('securite/permission/store', [PrivilageController::class, 'storePermission'])->name('permission.store');
    Route::get('securite/permission/edit/{id}', [PrivilageController::class, 'editPermission'])->name('permission.edit');
    Route::patch('securite/permission/update/{id}', [PrivilageController::class, 'updatePermission'])->name('permission.update');
    Route::delete('securite/permission/delete/{id}', [PrivilageController::class, 'deletePermission'])->name('permission.delete');

    //Roles
    Route::get('securite/role/index', [PrivilageController::class, 'indexRole'])->name('role.index');
    Route::get('securite/role/create', [PrivilageController::class, 'createRole'])->name('role.create');
    Route::post('securite/role/store', [PrivilageController::class, 'storeRole'])->name('role.store');
    Route::get('securite/role/edit/{id}', [PrivilageController::class, 'editRole'])->name('role.edit');
    Route::patch('securite/role/update/{id}', [PrivilageController::class, 'updateRole'])->name('role.update');
    Route::delete('securite/role/delete/{id}', [PrivilageController::class, 'deleteRole'])->name('role.delete');
    
    /**
     * Transactions
     */
    Route::get('transactions/index', [TransactionController::class, 'index'])->name('transaction.index');
    Route::post('transactions/filter', [TransactionController::class, 'filter'])->name('transaction.filter');
    Route::get('transactions/mesTransactions', [TransactionController::class, 'mesTransactions'])->name('transaction.mesTransactions');
    
    //bilan
    //Route::get('transactions/bilan', [TransactionController::class, 'bilan'])->name('transaction.bilan');
    Route::get('transactions/{moi}', [TransactionController::class, 'bilan'])->name('transaction.bilan');

    /**
     * charge
     */
     //// Gestion des charge /////
     Route::get('charges', [ChargeController::class, 'index'])->name('charges.index');
     Route::get('charges/create', [ChargeController::class, 'create'])->name('charges.create');
     Route::post('charges/store', [ChargeController::class, 'store'])->name('charges.store');
     Route::get('charges/add/{id}', [ChargeController::class, 'add'])->name('charges.add');
     Route::post('charges/add/{id}', [ChargeController::class, 'addDetail'])->name('charges.addDetail');
     Route::get('charges/showDetail/{id}', [ChargeController::class, 'showChargeDetail'])->name('charges.showChargeDetail');
     
     /**
     * utilisateurs
     */
    Route::get('users/index', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
    Route::get('users/edit/admin/{id}', [UserController::class, 'editAdmin'])->name('users.edit.admin');
    Route::patch('users/update/admin/{id}', [UserController::class, 'updateAdmin'])->name('users.update.admin');

    /**
     * Taches
     */
     Route::get('taches/index', [TacheController::class, 'index'])->name('taches.index');

     /**
      * recus
      */
});






require __DIR__.'/auth.php';
