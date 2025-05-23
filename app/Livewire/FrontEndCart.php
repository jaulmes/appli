<?php

namespace App\Livewire;

use App\Models\Produit;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FrontEndCart extends Component
{
    public $cart = [], $panier_pack, $quantity, 
            $montantTotal, $quantities = [];

    protected $listeners =[
        'ProduitAjoute' => 'mount',
        'ajouter_pack_panier' => 'mount'
    ];

    public function mount(){
        $this->cart = Session::get('frontEndCart', []);
        $this->panier_pack = Session::get('parnier_pack', []);
        //calcul du montant total du panier(pack et produit)
        $this->montantTotal = array_reduce($this->panier_pack, function($total, $pack) {
                                    $price = $pack['prix'];
                                    return $total + ($pack['quantity'] * $price);
                                }, 0) + array_reduce($this->cart, function($total, $produit) {
                                    $price = $produit['status_promo'] == 0 ? $produit['price'] : $produit['prix_promo'];
                                    return $total + ($produit['quantity'] * $price);
                                }, 0);
    }

    public function retirerProduit($id, $type){
        if($type == 'produit') {//retrait des produits
            unset($this->cart[$id]);
            Session::put('frontEndCart', $this->cart);
            $this->cart = Session::get('frontEndCart', []);
        }elseif($type == 'pack'){// retrait des packs
            unset($this->panier_pack[$id]);
            Session::put('parnier_pack', $this->panier_pack);
            $this->panier_pack = Session::get('parnier_pack', []);
        }
        $this->dispatch('ProduitRetire');
    }

    public function modifier_quantite($key){
        if (Produit::find($key)) {
            // Mise à jour de la quantité pour l'article ciblé
            $this->cart[$key]['quantity'] = max(1,(int)$this->quantities[$key]);
    
            // Recalcul du montant total du panier
            $this->montantTotal = array_reduce($this->cart, function($total, $item) {
                $price = $item['status_promo'] ? $item['prix_promo'] : $item['price'];
                return $total + ($item['quantity'] * $price);
            }, 0);
    
            Session::put('frontEndCart', $this->cart);
    
            // Notification du frontend
            $this->dispatch('quantiteModifier');
        }
   
    }


    public function vider_panier(){
        Session::forget('parnier_pack', []);
        Session::forget('frontEndCart', []);
        $this->dispatch('panierVide');
    }

    public function render()
    {
        return view('livewire.front-end-cart');
    }
}
