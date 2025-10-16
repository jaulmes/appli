<?php

namespace App\Livewire;

use App\Models\Achat;
use App\Models\Compte;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ModalSupprimerAprovionnement extends Component
{
        public $achat, $raison;
    
    public function delete(){
        DB::beginTransaction();
        try {
            if(!$this->raison){
                return redirect()->back()->with('error', 'Veuillez entrer le motif de suppression de l\'achat');
            }
            $achat = Achat::with('produits')->find($this->achat->id);
            //retrait des produits du stock
            foreach($achat->produits as  $produit){
                $produit->stock -= $produit->pivot->quantity;
                $produit->save();
                $achat->produits()->detach($produit->id);
            }

            //mise a jours du montant dans le compte
            if($achat->compte){
                $compte = Compte::where('id', $achat->compte_id)->first();
                if($compte){
                    $compte->montant += $achat->montantVerse;
                    $compte->save();
                }
            }

            $achat->delete();
            
            $transactions = new Transaction();
            $transactions->type = 'suppression achat pour raison : ' . $this->raison;
            $transactions->user_id = Auth::user()->id;
            $transactions->save();
            DB::commit();
            session()->flash('message', 'Achat supprimé avec succès');
            return redirect()->route('achats.index');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Une erreur est survenue lors de la suppression de l\'approvisionnement : ' . $e->getMessage());
            return;
        }
    }

    public function mount($achat){
        $this->achat = $achat;
    }
    public function render()
    {
        return view('livewire.modal-supprimer-aprovionnement');
    }
}
