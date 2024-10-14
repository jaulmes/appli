<?php

namespace App\Http\Controllers;

use App\Imports\ProduitsImport;
use App\Models\Categori;
use App\Models\Fournisseur;
use App\Models\Produit;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Auth;

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
        return view('produits.ajouter', compact('categories', 'fournisseurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       $request->validate([
            // 'name' => 'required|unique:'.Produit::class,
            'prix_achat' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'prix_minimum' => 'required|integer|min:0',
            'prix_technicien' => 'required|integer|min:0',
            'categori_id' => 'required',
            'stock' => 'required|integer|min:0'

        ]);


        $produits = new Produit();

        $produits->name = $request->input('name');
        $produits->description = $request->input('description');
        $produits->categori_id = $request->input('categori_id');
        $produits->prix_achat = $request->input('prix_achat');
        $produits->price = $request->input('price');
        $produits->prix_technicien = $request->input('prix_technicien');
        $produits->prix_minimum = $request->input('prix_minimum');
        $produits->stock = $request->input('stock');
        $produits->fabricant = $request->input('fabricant');

        if ($file = $request->file('image_produit')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
            $path = 'public/images/produits/';

            /**
             * Delete an image if exists.
             */
            if($produits->image_produit){
                Storage::delete($path . $produits->image_produit);
            }

            // Store an image to Storage
            $file->storeAs($path, $fileName);
            $produits->image_produit = $fileName;
        }

        else{
            $produits->image_produit = '';
        }
        
        $dateHeure = now();
        
        //enregistrer l'historique
        $transactions = new Transaction();
        $transactions->date = $dateHeure->format('d/m/y');
        $transactions->heure = $dateHeure->format('H:i:s');
        $transactions->type = "enregistrement d'un nouveau produit";
        $transactions->user_id = Auth::user()->id;
        
        if($produits->stock == 0){
            $transactions->prixAchat = $produits->prix_achat;
        }
        else{
            $transactions->prixAchat = $produits->prix_achat * $produits->stock;
        }
        
        $transactions->save();
        $produits->save();

        //relier le produit a son fournisseur
        $produits->fournisseurs()->attach($request->fournisseur_id, [
            'price' => $produits->prix_achat,
            'quantity' => $produits->stock
        ]);


        return redirect::route('produit.index')->with('message', 'produit ajouté avec succes!');
    }
    
    //afficher le formulaire de modification du produit
    public function show(string $id){
        $produit = Produit::find($id);
        $categories = Categori::all();
        
        return view('produits.edit', compact('produit', 'categories'));
    }

    //modifier le produit
    public function edit(Request $request, string $id)
    {
        
        $request->validate([
            'prix_achat' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'prix_minimum' => 'required|integer|min:0',
            'prix_technicien' => 'required|integer|min:0',
            'categori_id' => 'required',
            'stock' => 'required|integer|min:0'

        ]);
        
        
        $produits = Produit::find($id);
        
        $produits->name = $request->input('name');
        $produits->description = $request->input('description');
        $produits->categori_id = $request->input('categori_id');
        $produits->prix_achat = $request->input('prix_achat');
        $produits->price = $request->input('price');
        $produits->prix_technicien = $request->input('prix_technicien');
        $produits->prix_minimum = $request->input('prix_minimum');
        $produits->stock = $request->input('stock');
        $produits->fabricant = $request->input('fabricant');

        if ($file = $request->file('image_produit')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
            $path = 'public/images/produits/';

            // Delete an image if exists.
             

            // Store an image to Storage
            $file->storeAs($path, $fileName);
            $produits->image_produit = $fileName;
        }

        else{
            $produits->image_produit = '';
        }
        
        $dateHeure = now();
        
        //enregistrer l'historique
        $transactions = new Transaction();
        $transactions->date = $dateHeure->format('d/m/y');
        $transactions->heure = $dateHeure->format('H:i:s');
        $transactions->type = "modification d'un produit";
        $transactions->impot = $request->impot;
        $transactions->user_id = Auth::user()->id;
        
        if($produits->stock == 0){
            $transactions->prixAchat = $produits->prix_achat;
        }
        else{
            $transactions->prixAchat = $produits->prix_achat * $produits->stock;
        }
        
        $transactions->save();

        $produits->save();
        return redirect::route('produit.index')->with('message', ' produit modifie avec succes!');
        
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
        Produit::where('id', $id)->delete();
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

    //enregistrer les donnees des produits provenant du fichier excel
    public function storeImportProduit(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        try{

            Excel::import(new ProduitsImport, $request->file('file'));
           
            return Redirect::route('produit.index')->with('message', 'liste de produit importé avec succes');
            
        }
        catch (ValidationException $e){            
            $failures = $e->failures();
            foreach($failures as $failure){
                $attribute = $failure->attribute();
                $errors = $failure->errors();
            }

            return redirect()->back()->with('message', 'echec!!!');
        }

        dd($request);

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

        $categories->save();
        return redirect()->back()->with('message', 'categorie ajoutée avec succes!');
    }
    



}
