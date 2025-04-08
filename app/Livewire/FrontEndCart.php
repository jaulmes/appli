<?php

namespace App\Livewire;

use App\Models\Produit;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FrontEndCart extends Component
{
    public $cart = [], $quantity, $montantTotal, $quantities = [];

    protected $listeners =[
        'ProduitAjoute' => 'mount',
    ];

    public function mount(){
        $this->cart = Session::get('frontEndCart', []);
        //calcul du montant total du panier
        $this->montantTotal = array_reduce($this->cart, function($total, $produit) {
            $price = $produit['status_promo'] == 0 ? $produit['price'] : $produit['prix_promo'];
            return $total + ($produit['quantity'] * $price);
        }, 0);
    }

    public function retirerProduit($id){
        unset($this->cart[$id]);
        Session::put('frontEndCart', $this->cart);
        $this->cart = Session::get('frontEndCart', []);
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
        Session::forget('frontEndCart', []);
        $this->dispatch('panierVide');
    }

    public function render()
    {
        return view('livewire.front-end-cart');
    }
}
