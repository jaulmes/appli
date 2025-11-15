<?php

namespace App\Http\Controllers;

use App\Events\Vente;
use App\Imports\ProduitsImport;
use App\Models\Categori;
use App\Models\Compte;
use App\Models\Fournisseur;
use App\Models\Produit;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\VenteProduit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class produitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        // Récupérer la requête de recherche de l'utilisateur
        $search = $request->input('search');
    
        // Si une recherche est entrée, filtrer les produits
        if ($search) {
            $produits = Produit::where('name', 'LIKE', "%{$search}%")
                                ->get();
        } else {
            // Sinon, récupérer tous les produits
            $produits = Produit::all();
        }

        return view('produits.index', compact('produits'));
    }
    
    //rechercher un produit pour le stock
    public function search(Request $request){
        $query = $request->input('q');
        
        $produits = Produit::where('name', 'like', "%$query%")
                ->orWhere('description', 'like', "%$query%" )
                ->get();
                
                
        return view('produits.search', compact('quantite'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categori::all();
        $fournisseurs = Fournisseur::all();
        $comptes = Compte::all();
        return view('produits.ajouter', compact('categories', 'fournisseurs', 'comptes'));
    }
    
    //afficher le formulaire de modification du produit
    public function show(string $id){
        $produit = Produit::find($id);
        $categories = Categori::all();
        $fournisseurs = Fournisseur::all();
        $comptes = Compte::all();
        
        return view('produits.edit', compact('produit', 'categories', 'fournisseurs' ,'comptes'));
    }

    //modifier le produit
public function edit(Request $request, string $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'categori_id' => 'required',
        'prix_achat' => 'required|integer|min:0',
        'price' => 'required|integer|min:0',
        'prix_minimum' => 'required|integer|min:0',
        'prix_technicien' => 'required|integer|min:0',
        'stock' => 'required|integer|min:0',
        'fabricant' => 'nullable|string',
        'images.*' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048',
        'fournisseur_id' => 'nullable|exists:fournisseurs,id',
        'compte_principal_id' => 'nullable|exists:comptes,id',
        'compte_secondaire_id' => 'nullable|exists:comptes,id',
        'montant_principal' => 'nullable|integer|min:0',
        'montant_secondaire' => 'nullable|integer|min:0',
        'deleted_images' => 'nullable|string',
        'delete_old_single_image' => 'nullable|boolean',
    ]);

    DB::beginTransaction();
    try {
        $produit = Produit::findOrFail($id);
        $ancienStock = $produit->stock;
        $nouveauStock = $request->stock;
        $diffStock = $nouveauStock - $ancienStock;

        // Mise à jour des informations de base
        $produit->name = $request->name;
        $produit->description = $request->description;
        $produit->categori_id = $request->categori_id;
        $produit->prix_achat = $request->prix_achat;
        $produit->price = $request->price;
        $produit->prix_technicien = $request->prix_technicien;
        $produit->prix_minimum = $request->prix_minimum;
        $produit->stock = $request->stock;
        $produit->fabricant = $request->fabricant;

        // ========================================
        // GESTION DU STOCK ET DES COMPTES
        // ========================================
        
        if ($diffStock > 0) {
            $coutAjout = $request->prix_achat * $diffStock;

            if (!$request->compte_principal_id) {
                throw new Exception('Un compte principal est requis pour augmenter le stock.');
            }

            $compte_principal = Compte::find($request->compte_principal_id);
            if (!$compte_principal) {
                throw new Exception('Compte principal introuvable.');
            }

            if ($coutAjout > $compte_principal->montant) {
                if (!$request->compte_secondaire_id || !$request->montant_principal || !$request->montant_secondaire) {
                    throw new Exception('Les informations du compte secondaire sont requises car le solde du compte principal est insuffisant.');
                }

                if ($request->montant_principal + $request->montant_secondaire !== $coutAjout) {
                    throw new Exception('La somme des montants doit égaler le coût de l\'ajout (' . $coutAjout . ' FCFA).');
                }

                $compte_secondaire = Compte::find($request->compte_secondaire_id);
                if (!$compte_secondaire) {
                    throw new Exception('Compte secondaire introuvable.');
                }

                if ($request->montant_principal > $compte_principal->montant) {
                    throw new Exception('Le montant à prélever du compte principal dépasse son solde.');
                }

                if ($request->montant_secondaire > $compte_secondaire->montant) {
                    throw new Exception('Le montant à prélever du compte secondaire dépasse son solde.');
                }

                if ($compte_principal->id === $compte_secondaire->id) {
                    throw new Exception('Les comptes principal et secondaire ne peuvent pas être identiques.');
                }

                $produit->comptes()->attach($compte_principal->id, [
                    'montant' => $request->montant_principal
                ]);

                $produit->comptes()->attach($compte_secondaire->id, [
                    'montant' => $request->montant_secondaire
                ]);

                $compte_principal->montant -= $request->montant_principal;
                $compte_principal->save();
                
                $compte_secondaire->montant -= $request->montant_secondaire;
                $compte_secondaire->save();

                Transaction::create([
                    'date' => now()->format('d/m/y'),
                    'heure' => now()->format('H:i:s'),
                    'type' => "ajout stock",
                    'user_id' => Auth::id(),
                    'montantVerse' => $request->montant_principal,
                    'prixAchat' => $request->montant_principal,
                    'compte_id' => $compte_principal->id,
                ]);

                Transaction::create([
                    'date' => now()->format('d/m/y'),
                    'heure' => now()->format('H:i:s'),
                    'type' => "ajout stock",
                    'user_id' => Auth::id(),
                    'montantVerse' => $request->montant_secondaire,
                    'prixAchat' => $request->montant_secondaire,
                    'compte_id' => $compte_secondaire->id,
                ]);

            } else {
                $produit->comptes()->attach($compte_principal->id, [
                    'montant' => $coutAjout
                ]);

                $compte_principal->montant -= $coutAjout;
                $compte_principal->save();

                Transaction::create([
                    'date' => now()->format('d/m/y'),
                    'heure' => now()->format('H:i:s'),
                    'type' => "ajout stock",
                    'user_id' => Auth::id(),
                    'montantVerse' => $coutAjout,
                    'prixAchat' => $coutAjout,
                    'compte_id' => $compte_principal->id,
                ]);
            }
        }

        // ========================================
        // GESTION DE LA SUPPRESSION DES IMAGES
        // ========================================
        
        // Supprimer l'ancienne image unique si demandé
        if ($request->delete_old_single_image == '1' && $produit->image_produit) {
            $oldImagePath = public_path('images/produits/' . $produit->image_produit);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $produit->image_produit = null;
        }

        // Supprimer les images multiples sélectionnées
        if ($request->deleted_images) {
            $deletedImageIds = explode(',', $request->deleted_images);
            
            foreach ($deletedImageIds as $imageId) {
                $image = $produit->images()->find($imageId);
                if ($image) {
                    $imagePath = public_path('images/produits/' . $image->path);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    $image->delete();
                }
            }
        }

        // ========================================
        // AJOUT DE NOUVELLES IMAGES
        // ========================================
        
        if ($request->hasFile('images')) {
            // Ajouter les nouvelles images (sans supprimer les anciennes restantes)
            foreach ($request->file('images') as $image) {
                $fileName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $destinationPath = 'images/produits';

                if (!file_exists(public_path($destinationPath))) {
                    mkdir(public_path($destinationPath), 0755, true);
                }

                $image->storeAs($destinationPath, $fileName, 'real_public');

                $produit->images()->create([
                    'path' => $fileName,
                    'is_gif' => strtolower($image->getClientOriginalExtension()) === 'gif',
                ]);
            }
        }

        // Mise à jour du fournisseur si fourni
        if ($request->fournisseur_id) {
            $produit->fournisseurs()->sync([
                $request->fournisseur_id => [
                    'price' => $request->prix_achat,
                    'quantity' => $request->stock
                ]
            ]);
        }

        // Transaction de modification
        Transaction::create([
            'date' => now()->format('d/m/y'),
            'heure' => now()->format('H:i:s'),
            'type' => "modification produit",
            'user_id' => Auth::id(),
            'prixAchat' => $request->prix_achat * $request->stock,
            'compte_id' => $request->compte_principal_id ?? null,
        ]);

        $produit->save();

        DB::commit();

        return redirect()->route('produit.index')->with('message', 'Produit modifié avec succès !');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Erreur : ' . $e->getMessage())->withInput();
    }
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produit = Produit::with('comptes')->find( $id);

        $comptes = $produit->comptes;
        foreach($comptes as $compte){
            $compte->montant -= $compte->pivot->montant;
        }
        $produit->comptes()->detach();
        //supprimer l'image du produit
        if($produit->image_produit){
            $imagePath1 = public_path('images/produits/' . $produit->image_produit);
            $imagePath2 = public_path('storage/images/produits/' . $produit->image_produit);
            if (file_exists($imagePath1)) {
                unlink($imagePath1);
            } elseif (file_exists($imagePath2)) {
                unlink($imagePath2);
            }
        }
        $produit->delete();
        
        session()->flash("message", "vous avez supprime ce produit...");
        return redirect()->route('produit.index');
    }

    /**
     * improter des produit dans un doccument excel
     */

    //efficher la vue d'importation de fichier excel
    public function importProduit(){
        return view('produits.import');
    }

    /**
     * gerer les categories des produits
     */

     //afficher les categories
    public function index_categorie(){
        $categories = Categori::all();
        return view('produits.categories', compact('categories'));
    }

    //efficherr la vue pour creer des categories
    public function create_categorie(){
        return view('produits.ajouter_categorie');
    }

    //enregistrer la categorie dans la base de donnee
    public function store_categories(Request $request)  {
        $categories = new Categori();
        
        $categories->titre = $request->input('titre');
        $categories->description = $request->input('description');

        if ($file = $request->file('image_categorie')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
            $path = 'images/produits/categories';
            /**
             * Delete an image if exists.
             */
            if($categories->image_categorie){
                Storage::delete($path . $categories->image_categorie);
            }
            // Store an image to Storage
            $file->storeAs($path, $fileName, 'real_public');
            $categories->image_categorie = $fileName;
        }
        else{
            $categories->image_categorie = '';
        }

        $dateHeure = now();
        //enregistrer l'historique
        $transactions = new Transaction();
        $transactions->date = $dateHeure->format('d/m/y');
        $transactions->heure = $dateHeure->format('H:i:s');
        $transactions->type = "Nouvelle categorie de produit";
        $transactions->user_id = Auth::user()->id;
        

        $transactions->save();
        $categories->save();
        return redirect()->back()->with('message', 'categorie ajoutée avec succes!');
    }

    public function show_categories($id){
        $categories = Categori::find($id);
        return view('produits.edit_categorie',
                        [
                            'categories' => $categories
                        ]
                    );
    }
    
    //enregistrer la categorie dans la base de donnee
    public function edit_categories(Request $request, $id)  {
        $categories = Categori::find($id);
        
        $categories->titre = $request->input('titre');
        $categories->description = $request->input('description');

        if ($file = $request->file('image_categorie')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
            $path = 'images/produits/categories';
            /**
             * Delete an image if exists.
             */
            if($categories->image_categorie){
                Storage::delete($path . $categories->image_categorie);
            }
            // Store an image to Storage
            $file->storeAs($path, $fileName, 'real_public');
            $categories->image_categorie = $fileName;
        }
        else{
            $categories->image_categorie = '';
        }

        $dateHeure = now();
        //enregistrer l'historique
        $transactions = new Transaction();
        $transactions->date = $dateHeure->format('d/m/y');
        $transactions->heure = $dateHeure->format('H:i:s');
        $transactions->type = "modification de la categorie produit";
        $transactions->user_id = Auth::user()->id;

        $transactions->save();
        $categories->save();
        return redirect()->back()->with('message', 'categorie modifiée avec succes!');
    }

    //supprimer une categorie
    public function delete_categories($id){
        Categori::where('id', $id)->delete();
        session()->flash("message", "vous avez supprime cette categorie...");
        return redirect()->route('produit.categori');
    }

}
