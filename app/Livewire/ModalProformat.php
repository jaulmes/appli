<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ModalProformat extends Component
{
    // Déclarer cart en tant que tableau (depuis PHP 7.4)
    public array $cart = []; 

    // Écoute les événements et exécute la fonction montantTotal
    protected $listeners = [
        'ProduitAjoute'    => 'montantTotal',
        'quantiteModifier'  => 'montantTotal',
        'prix_change'       => 'montantTotal',
        'ProduitRetire'     => 'montantTotal',
        'panierVide'        => 'montantTotal'
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
        return view('livewire.modal-proformat');
    }
}
