<?php

namespace App\Livewire;

use App\Models\Annonce;
use App\Models\Produit;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class FrontEndAnnonceAdmin extends Component
{
    use WithFileUploads;

    public $annonces;
    public $image;
    public $produit_id;
    public $service_id;
    public $status;
    public $produits, $services;

    public function mount()
    {
        $this->annonces = Annonce::all();
        $this->produits = Produit::all();
        $this->services = Service::all();
    }

    public function changeStatus($id){
        $annonce = Annonce::find($id);
        if ($annonce) {
            if($annonce->status == 'actif'){
                $annonce->status = 'desactiver';
            } else {
                $annonce->status = 'actif';
            }
            $annonce->save();
            $this->annonces = Annonce::all();
            session()->flash('annonce_sucess', 'Annonce status updated successfully.');
        } else {
            session()->flash('error', 'Annonce not found.');
        }
    }

    public function deleteAnnonce($id)
    {
        $annonce = Annonce::find($id);
        if ($annonce) {
            $annonce->delete();
            $this->annonces = Annonce::all();
            session()->flash('message', 'Annonce deleted successfully.');
        } else {
            session()->flash('error', 'Annonce not found.');
        }
    }
    public function render()
    {
        return view('livewire.front-end-annonce-admin');
    }
}
