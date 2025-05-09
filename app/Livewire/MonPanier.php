<?php

namespace App\Livewire;

use App\Models\Produit;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class MonPanier extends Component
{
    public $cartContent = [];
    public $new_price = [];
    public $cart = [];
    public $quantity = [];

    protected $listeners = ['ProduitAjoute' => 'updateCart',
                            'produitAjoute' => '$refresh',
                            'panierVide' => 'updateCart',
                            'prix_change' => 'updateCart'];


    public function updateCart(){
        $this->cart = session()->get('cart', []);
    }

    //mettre a jour la quantite
    public function ajouterQuantite($id){
        //je recupere le produit dans le systeme avec son Id
        $produits = Produit::find($id);
        //je recupere le produit dans le panier
        $item = $this->cart[$produits->id];

        $quantity = (int)$item['quantity'] + 1;
        $this->cart[$produits->id]['quantity'] = $quantity;
        Session::put('cart', $this->cart);

        $this->dispatch('quantiteModifier');

    }

    public function update_prix($id){
        $produits = Produit::find($id);

        $item = $this->cart[$produits->id];
    
        $item['price'] = (int)$this->new_price[$produits->id];
        $this->cart[$produits->id]['price'] = $item['price'];
        Session::put('cart', $this->cart);
        

        //\Cart::update($item->id, ['price' => $this->new_price ]);
        
        $this->dispatch('prix_change');
    }

    //mettre a jour la quantite
    public function diminuerQuantite($id){
        //je recupere le produit dans le systeme avec son Id
        $produits = Produit::find($id);
        //je recupere le produit dans le panier
        $item = $this->cart[$produits->id];

        if($item['quantity'] > 0){
            $quantity = (int)$item['quantity'] -1;
            $this->cart[$produits->id]['quantity'] = $quantity;
            Session::put('cart', $this->cart);
    
            $this->dispatch('quantiteModifier');
        }

    }

    public function modifierQuantite($id){
        $produits = Produit::find($id);
        $this->cart[$produits->id]['quantity'] = (int)$this->quantity[$produits->id];
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
            $total += (int)$item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function mount(){
        $this->cart = session()->get('cart', []);
    }


    public function render()
    {
        return view('livewire.mon-panier');
    }
}
