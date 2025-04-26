<?php

namespace App\Livewire;

use App\Models\Produit;
use Livewire\Component;
use Darryldecode\Cart\Cart;
use Illuminate\Support\Facades\Session;

class PanierAprovisionnement extends Component
{
    public $cart, $new_price = [], $quantity = [];

    protected $listeners = [
        'ProduitAjoute' => 'updateCart',
        'produitAjoute' => '$refresh',
        'panierVide' => 'updateCart',
        'prix_change' => 'updateCart'
    ];


    public function updateCart(){
        $this->cart = session()->get('cart', []);
    }

    //mettre a jour la quantite
    public function ajouterQuantite($id){
        //je recupere le produit dans le systeme avec son Id
        $produits = Produit::find($id);
        //je recupere le produit dans le panier
        $item = $this->cart[$produits->id];

        $quantity = $item['quantity'] + 1;
        $this->cart[$produits->id]['quantity'] = $quantity;
        Session::put('cart', $this->cart);

        $this->dispatch('quantiteModifier');

    }

    public function update_prix($id){
        $produits = Produit::find($id);

        $item = $this->cart[$produits->id];
    
        $item['prix_achat'] = $this->new_price[$produits->id];
        $this->cart[$produits->id]['prix_achat'] = $item['prix_achat'];
        Session::put('cart', $this->cart);
        
        $this->dispatch('prix_change');
    }

    //mettre a jour la quantite
    public function diminuerQuantite($id){
        //je recupere le produit dans le systeme avec son Id
        $produits = Produit::find($id);
        //je recupere le produit dans le panier
        $item = $this->cart[$produits->id];

        if($item['quantity'] > 0){
            $quantity = $item['quantity'] -1;
            $this->cart[$produits->id]['quantity'] = $quantity;
            Session::put('cart', $this->cart);
    
            $this->dispatch('quantiteModifier');
        }

    }

    public function modifierQuantite($id){
        $produits = Produit::find($id);
        $this->cart[$produits->id]['quantity'] = $this->quantity[$produits->id];
        Session::put('cart', $this->cart);
        $this->dispatch('quantiteModifier');
    } 

    public function retirerProduit($id){
        unset($this->cart[$id]);
        Session::put('cart', $this->cart);
        $this->cart = Session::get('cart', []);
        $this->dispatch('ProduitRetire');
    }



    public function viderPanier(){
        $this->cart = [];

        session()->forget('cart');
        $this->cart = Session::get('cart', []); 
        $this->dispatch('panierVide');
    }

    public function panierTotal(){
        $total = 0;
        foreach($this->cart as $item){
            $total += (int)$item['prix_achat'] * $item['quantity'];
        }
        return $total;
    }

    public function mount(){
        $this->cart = session()->get('cart', []);
    }
    public function render()
    {
        return view('livewire.panier-aprovisionnement');
    }
}
