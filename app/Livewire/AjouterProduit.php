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

    public function ajouter_compte(){
        $compte = Compte::find($this->compte_principal_id);
        if($this->stock > 0 && $this->prix_achat * $this->stock > $compte->montant){
            return true;
        }else{
            return false;
        }
        
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

            if ($this->image_produit) {
                $fileName = hexdec(uniqid()) . '.' . $this->image_produit->getClientOriginalExtension();
                $destinationPath = 'images/produits';

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                // Supprime l’ancienne image si elle existe
                if ($produit->image_produit && file_exists($destinationPath . '/' . $produit->image_produit)) {
                    unlink($destinationPath . '/' . $produit->image_produit);
                }

                $this->image_produit->storeAs($destinationPath, $fileName, 'real_public');


                $produit->image_produit = $fileName;
            }
            else{
                $produit->image_produit = $produit->image_produit;
            }

            $produit->save();

            $totalCost = $this->prix_achat * $this->stock;
            //paiement avec different compte si le compte principal n'est pas suffisant
            if($this->stock > 0){
                $compte_principal = Compte::find($this->compte_principal_id);
                if($this->prix_achat * $this->stock > $compte_principal->montant){
                    $compte_secondaire = Compte::find($this->compte_secondaire_id);

                    if($this->prix_achat * $this->stock <= $compte_principal->montant + $compte_secondaire->montant){
                        $produit->comptes()->attach($compte_principal->id, [
                            'montant' => $this->montant_principal
                        ]);


                        $produit->comptes()->attach($compte_secondaire->id, [
                            'montant' => $this->montant_secondaire
                        ]);

                        //mise a jour des deux comptes selectionnés
                        $compte_principal->montant =  $compte_principal->montant - $this->montant_principal;
                        $compte_principal->save();
                        $compte_secondaire->montant =  $compte_secondaire->montant - $this->montant_secondaire;
                        $compte_secondaire->save();
                    }else{
                        return redirect()->back()->with('error', 'solde insufisant dans les deux comptes, veillez recharger');
                    }
                }
                //liaison avec un seul compte si le montant dans le compte est sufisant pour effectuer l'achat
                else{
                    $this->montant_principal = $totalCost;
                    $produit->comptes()->attach($compte_principal->id, [
                        'montant' => $this->montant_principal
                    ]);
                    $compte_principal->montant =  $compte_principal->montant - $this->montant_principal;
                    $compte_principal->save();

                    //enregistrement de la transaction principale
                    $transactionPrincipal = new Transaction();
                    $transactionPrincipal->type = "achat";
                    $transactionPrincipal->montantVerse = $this->montant_principal;
                    $transactionPrincipal->compte_id = $compte_principal->id;
                    $transactionPrincipal->save();
                }
            }

            $dateHeure = now();

            $transaction = new Transaction([
                'date' => $dateHeure->format('d/m/y'),
                'heure' => $dateHeure->format('H:i:s'),
                'type' => "Nouveau produit",
                'user_id' => Auth::id(),
                'prixAchat' => $totalCost,
                'compte_id' => $compte_principal->id,
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
            //dd($e->getMessage());
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
