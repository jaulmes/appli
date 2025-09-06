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
           $image_produit, $fournisseur_id, $compte_principal_id, 
           $montant_principal, $compte_secondaire_id, $montant_secondaire,
           $categories, $fournisseurs, $comptes;

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
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'image_produit' => 'nullable|image|max:2048',
        ];
    }

    public function ajouter_compte()
    {
        if (!$this->compte_principal_id || $this->stock <= 0) {
            return false;
        }
        
        $compte = Compte::find($this->compte_principal_id);
        if (!$compte) {
            return false;
        }
        
        $totalCost = $this->prix_achat * $this->stock;
        return $totalCost > $compte->montant;
    }

    public function afficher_compte()
    {
        return $this->stock > 0;
    }

    public function store()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            // Création du produit
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

            // Gestion de l'image
            if ($this->image_produit) {
                $fileName = hexdec(uniqid()) . '.' . $this->image_produit->getClientOriginalExtension();
                $destinationPath = 'images/produits';

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $this->image_produit->storeAs($destinationPath, $fileName, 'real_public');
                $produit->image_produit = $fileName;
            }

            $produit->save();

            $totalCost = $this->prix_achat * $this->stock;
            $compte_principal = null;

            // Gestion des comptes et transactions selon le stock
            if ($this->stock > 0) {
                // Validation des comptes pour stock > 0
                if (!$this->compte_principal_id) {
                    throw new Exception('Un compte principal est requis lorsque le stock est supérieur à 0.');
                }

                $compte_principal = Compte::find($this->compte_principal_id);
                if (!$compte_principal) {
                    throw new Exception('Compte principal introuvable.');
                }

                // Vérification si un second compte est nécessaire
                if ($totalCost > $compte_principal->montant) {
                    if (!$this->compte_secondaire_id || !$this->montant_principal || !$this->montant_secondaire) {
                        throw new Exception('Les informations du compte secondaire sont requises car le solde du compte principal est insuffisant.');
                    }

                    if ($this->montant_principal + $this->montant_secondaire !== $totalCost) {
                        throw new Exception('La somme des montants doit égaler le coût total (' . $totalCost . ' FCFA).');
                    }

                    $compte_secondaire = Compte::find($this->compte_secondaire_id);
                    if (!$compte_secondaire) {
                        throw new Exception('Compte secondaire introuvable.');
                    }

                    // Vérification des soldes
                    if ($this->montant_principal > $compte_principal->montant) {
                        throw new Exception('Le montant à prélever du compte principal dépasse son solde.');
                    }

                    if ($this->montant_secondaire > $compte_secondaire->montant) {
                        throw new Exception('Le montant à prélever du compte secondaire dépasse son solde.');
                    }

                    if ($compte_principal->id === $compte_secondaire->id) {
                        throw new Exception('Les comptes principal et secondaire ne peuvent pas être identiques.');
                    }

                    // Paiement avec deux comptes
                    $produit->comptes()->attach($compte_principal->id, [
                        'montant' => $this->montant_principal
                    ]);

                    $produit->comptes()->attach($compte_secondaire->id, [
                        'montant' => $this->montant_secondaire
                    ]);

                    // Mise à jour des soldes
                    $compte_principal->montant -= $this->montant_principal;
                    $compte_principal->save();
                    
                    $compte_secondaire->montant -= $this->montant_secondaire;
                    $compte_secondaire->save();

                    // Transactions pour les deux comptes
                    Transaction::create([
                        'date' => now()->format('d/m/y'),
                        'heure' => now()->format('H:i:s'),
                        'type' => "achat",
                        'user_id' => Auth::id(),
                        'montantVerse' => $this->montant_principal,
                        'prixAchat' => $this->montant_principal,
                        'compte_id' => $compte_principal->id,
                    ]);

                    Transaction::create([
                        'date' => now()->format('d/m/y'),
                        'heure' => now()->format('H:i:s'),
                        'type' => "achat",
                        'user_id' => Auth::id(),
                        'montantVerse' => $this->montant_secondaire,
                        'prixAchat' => $this->montant_secondaire,
                        'compte_id' => $compte_secondaire->id,
                    ]);

                } else {
                    // Paiement avec un seul compte (solde suffisant)
                    $produit->comptes()->attach($compte_principal->id, [
                        'montant' => $totalCost
                    ]);

                    // Mise à jour du solde
                    $compte_principal->montant -= $totalCost;
                    $compte_principal->save();

                    // Transaction pour le compte principal
                    Transaction::create([
                        'date' => now()->format('d/m/y'),
                        'heure' => now()->format('H:i:s'),
                        'type' => "achat",
                        'user_id' => Auth::id(),
                        'montantVerse' => $totalCost,
                        'prixAchat' => $totalCost,
                        'compte_id' => $compte_principal->id,
                    ]);
                }
            }

            // Transaction générale pour le nouveau produit
            Transaction::create([
                'date' => now()->format('d/m/y'),
                'heure' => now()->format('H:i:s'),
                'type' => "Nouveau produit",
                'user_id' => Auth::id(),
                'prixAchat' => $totalCost,
                'compte_id' => $compte_principal ? $compte_principal->id : null,
            ]);

            // Liaison avec le fournisseur
            $produit->fournisseurs()->attach($this->fournisseur_id, [
                'price' => $this->prix_achat,
                'quantity' => $this->stock
            ]);

            // Liaison de la transaction avec le produit
            $lastTransaction = Transaction::latest()->first();
            $lastTransaction->produits()->attach($produit->id, [
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