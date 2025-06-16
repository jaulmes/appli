<?php

namespace App\Livewire;

use App\Models\BonCommande;
use Livewire\Component;

class ModalEditBonCommande extends Component
{
    public $bon, $status, $date_livraison;

    public function editBon($id){
        $bon = BonCommande::find($id);
        $bon->status = $this->status;
        $bon->date_livraison = $this->date_livraison;
        if($bon->status == 'livré'){
            foreach ($bon->produits as $produit) {
                $produit->stock = $produit->stock + $produit->pivot->quantity;
                $produit->save();
            }
        }

        $bon->save();
        session()->flash('success', 'Bon de commande mis à jour avec succès.');
        return redirect()->route('bonCommandes.index');
    }

    public function mount(BonCommande $bonCommande){
        $this->status = $bonCommande->status;
        $this->date_livraison = $bonCommande->date_livraison;
        $this->bon = BonCommande::find($bonCommande->id);
    }

    public function render()
    {
        return view('livewire.modal-edit-bon-commande');
    }
}
