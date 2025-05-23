<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ModalCreerPack extends Component
{
    public $cart = [];

    public $listener = [
        'ProduitAjoute' => 'montantTotal',
        'produitAjoute' => '$refresh',
        'panierVide' => '$refresh',
        'panierVide' => 'montantTotal',
    ];

    // Fonction qui met à jour le panier et calcule le montant total
    // En forçant la conversion des valeurs numériques en entiers.
    public function montantTotal(): int
    {
        $this->cart = Session::get('cart', []);
        $total = 0;
        foreach($this->cart as $item) {
            // Si les clés existent, les caster en entier
            $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 0;
            $price    = isset($item['price']) ? (int)$item['price'] : 0;

            $total += $quantity * $price;
        }
        return $total;
    }

    public function render()
    {
        return view('livewire.modal-creer-pack');
    }
}
