<?php

namespace App\Livewire;

use App\Models\Produit;
use Livewire\Component;

class FrontEndModalAllProduct extends Component
{
    public $produit_promo;
    public $produit_non_promo;
    public $produit_id;
    public $prix_promo = [];
    public $status_promo;
    public $position_catalogue= [];
    public $position_promo = [];

    public $produit_selectionne = [];
    public $query = '';

    public function searchProduit()
    {
        $word = '%' . $this->query . '%';
        $this->produit_non_promo = Produit::where('name', 'like', '%'. $word . '%')
                                    ->orWhere('description', 'like', '%'. $word . '%')
                                    ->get();

    }

    public function submit(){
        
        foreach ($this->produit_selectionne as $productId) {
            
            $produit = Produit::find($productId);
            if ($produit) {

                if($this->position_catalogue == null){
                    $produit->position_catalogue = $produit->position_catalogue;
                } else {
                    $produit->position_catalogue = $this->position_catalogue[$productId];
                }
                if($this->position_promo == null){
                    $produit->position_promo = $produit->position_promo;
                } else {
                    $produit->position_promo = $this->position_promo[$productId];
                }
                if ($this->prix_promo == null) {
                    $produit->prix_promo = $produit->prix_promo;
                } else {
                    $produit->prix_promo = $this->prix_promo[$productId];
                }
                $produit->status_promo = 1;
                if (empty($produit->prix_promo)) {
                    session()->flash('error', 'Veuillez entrer le prix promo pour activer la promotion');
                    return;
                }
                else{
                    $produit->prix_promo = $produit->prix_promo?? $this->prix_promo[$productId];
                }
                

                
                $produit->save();
            }
        }
        session()->flash('message', 'Produit en promotion avec succès');
        return redirect()->route('frontend.admin.allPromoProduit');
    }

    public function mount(){
        $this->produit_promo = Produit::where('status_promo', 1)->get();
        $this->produit_non_promo = Produit::where('status_promo', 0)->get();
    }
    public function render()
    {
        return view('livewire.front-end-modal-all-product');
    }
}
