<?php

namespace App\Livewire;

use App\Models\Categori;
use App\Models\Compte;
use App\Models\Fournisseur;
use App\Models\Produit;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class AjouterProduit extends Component
{

    use WithFileUploads;

    public $name, $description, $categori_id, $prix_achat, $price,
           $prix_minimum, $prix_technicien, $stock, $fabricant,
           $image_produit, $fournisseur_id, $compte_id, $categories, $fournisseurs
           , $comptes;

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categori_id' => 'required',
            'prix_achat' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'prix_minimum' => 'required|integer|min:0',
            'prix_technicien' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'fabricant' => 'nullable|string',
            'compte_id' => 'required|exists:comptes,id',
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'image_produit' => 'nullable|image|max:2048',
        ];
    }

    public function store()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $produit = new Produit([
                'name' => $this->name,
                'description' => $this->description,
                'categori_id' => $this->categori_id,
                'prix_achat' => $this->prix_achat,
                'price' => $this->price,
                'prix_technicien' => $this->prix_technicien,
                'prix_minimum' => $this->prix_minimum,
                'stock' => $this->stock,
                'fabricant' => $this->fabricant,
            ]);

            //stocker l'image dans le dossier public/images/produits
if ($this->image_produit) {
    $filename = hexdec(uniqid()) . '.' . $this->image_produit->getClientOriginalExtension();
    $path = 'images/produits';

    // Créer le dossier s’il n’existe pas
    if (!file_exists(public_path($path))) {
        mkdir(public_path($path), 0755, true);
    }

    // Supprimer une ancienne image si nécessaire
    if ($produit->image_produit && file_exists(public_path($path . '/' . $produit->image_produit))) {
        unlink(public_path($path . '/' . $produit->image_produit));
    }

    // ⚠️ Utilise storeAs avec le disque 'public'
    $this->image_produit->storeAs($path, $filename, 'public');

    // Enregistre juste le nom du fichier
    $produit->image_produit = $filename;
}


            $produit->save();

            $comptes = Compte::findOrFail($this->compte_id);
            $totalCost = $this->prix_achat * $this->stock;

            if ($comptes->montant < $totalCost) {
                return session()->flash('error', 'Le solde du compte choisi est insuffisant.');
            }

            $comptes->montant -= $totalCost;
            
            $comptes->save();

            $dateHeure = now();

            $transaction = new Transaction([
                'date' => $dateHeure->format('d/m/y'),
                'heure' => $dateHeure->format('H:i:s'),
                'type' => "Nouveau produit",
                'user_id' => Auth::id(),
                'prixAchat' => $totalCost,
                'compte_id' => $comptes->id,
            ]);
            $transaction->save();

            $produit->fournisseurs()->attach($this->fournisseur_id, [
                'price' => $this->prix_achat,
                'quantity' => $this->stock
            ]);

            $transaction->produits()->attach($produit->id, [
                'price' => $this->prix_achat,
                'quantity' => $this->stock,
                'name' => $this->name,
            ]);

            DB::commit();

            session()->flash('message', 'Produit ajouté avec succès !');
            return redirect()->route('produit.index');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erreur: ' . $e->getMessage());
        }
    }

    public function mount()
    {
        $this->categories = Categori::all();
        $this->fournisseurs = Fournisseur::all();
        $this->comptes = Compte::all();
    }

    public function render()
    {
        return view('livewire.ajouter-produit');
    }
}
