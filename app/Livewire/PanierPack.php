<?php

namespace App\Livewire;

use App\Models\Produit;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class PanierPack extends Component
{
    public $cart = [], $new_price = [], $quantity = [];

    protected $listeners = [
        'produit_ajoute_pack' => 'updateCart',
        'Produit_ajoute_pack' => '$refresh',
        'panier_vide_pack' => 'updateCart',
        'prix_change_pack' => 'updateCart'
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
        session()->put('cart', $this->cart);

        $this->dispatch('quantiteModifier');

    }

    public function update_prix($id){
        $produits = Produit::find($id);

        $item = $this->cart[$produits->id];
    
        $item['price'] = $this->new_price[$produits->id];
        $this->cart[$produits->id]['price'] = $item['price'];
        session()->put('cart', $this->cart);
        
        $this->dispatch('prix_change_pack');
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
            session()->put('cart', $this->cart);
    
            $this->dispatch('quantiteModifier');
        }

    }

    public function modifierQuantite($id){
        $produits = Produit::find($id);
        $this->cart[$produits->id]['quantity'] = $this->quantity[$produits->id];
        session()->put('cart', $this->cart);
        $this->dispatch('quantiteModifier');
    } 

    public function retirerProduit($id){
        unset($this->cart[$id]);
        session()->put('cart', $this->cart);
        $this->cart = session()->get('cart', []);
        $this->dispatch('ProduitRetire');
    }

    public function viderPanier(){
        $this->cart = [];

        session()->forget('cart');
        $this->cart = session()->get('cart', []); 
        $this->dispatch('panier_vide_pack');
    }

    public function panierTotal(){
        $total = 0;
        foreach($this->cart as $item){
            $total += (int)$item['prix_catalogue'] * $item['quantity'];
        }
        return $total;
    }

    public function mount(){
        $this->cart = session()->get('cart', []);
    }

    public function render()
    {
        return view('livewire.panier-pack');
    }
}
