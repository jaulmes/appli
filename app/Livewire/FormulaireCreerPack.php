<?php

namespace App\Livewire;

use App\Models\Pack;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormulaireCreerPack extends Component
{
    use WithFileUploads;

    public $titre, $description, $prix, $image;

    public function enregistrer_pack(){
        $packs = new Pack();
        $packs->titre = $this->titre;
        $packs->description = $this->description;

        $prix_total = 0; 
        //je recupere le panier
        $cart = session()->get('cart', []);

        //je recupere le prix total des produits dans le panier
        foreach($cart as $item){
            $prix_total += $item['price'] * $item['quantity'];
        }
        
        $packs->prix = $prix_total;

        if ($this->image) {
            $fileName = hexdec(uniqid()).'.'.$this->image->getClientOriginalName();
            $imagePath = 'images/packs/';
            /**
             * Delete an image if exists.
             */
            if($packs->image){
                Storage::delete($imagePath . $packs->image);
            }
            // Store an image to Storage
            $this->image->storeAs($imagePath, $fileName, 'real_public');
            $packs->image = $fileName;
        }
        else{
            $packs->image = $packs->image;
        }

        $packs->save();

        //je relies les produits au pack
        foreach($cart as $item){
            $packs->produits()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }
        //je vide le panier
        session()->forget('cart');
        return redirect()->route('panier.pack.create');
    }

    public function render()
    {
        return view('livewire.formulaire-creer-pack');
    }
}
