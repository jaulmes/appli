<?php

namespace App\Livewire;

use App\Models\Annonce;
use App\Models\Produit;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class FrontEndAddAnnonceAdmin extends Component
{
    use WithFileUploads;

    public $produits, $services, $produit_choisi, 
            $service_choisi, $liaison, $status, $service_id,
            $produit_id, $image, $annonces;

    public function mount()
    {
        $this->annonces = Annonce::all();
        $this->produits = Produit::all();
        $this->services = Service::all();
    }

    public function addAnnonce()
    {

        $this->validate([
            'image' => 'required',
            'status' => 'required',
        ]);
        $annonce = new Annonce();
        if ($file = $this->image) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
            $imagePath = 'images/annonces/';
            /**
             * Delete an image if exists.
             */
            if($annonce->image){
                Storage::delete($imagePath . $annonce->image);
            }
            // Store an image to Storage
            $file->storeAs($imagePath, $fileName, 'real_public');
            $annonce->image = $fileName;
        }
        else{
            $annonce->image = '';
        }
        if ($this->produit_id) {
            $annonce->produit_id = $this->produit_id;
        } else {
            $annonce->produit_id = null;
        }
        $annonce->produit_id = $this->produit_id;
        $annonce->service_id = $this->service_id;
        $annonce->status = $this->status;
        $annonce->save();

        return redirect()->route('frontend.admin')->with('annonce_sucess', 'Annonce ajoutée avec succès');
    }
    public function render()
    {
        return view('livewire.front-end-add-annonce-admin');
    }
}
