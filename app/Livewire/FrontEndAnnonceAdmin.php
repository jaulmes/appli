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

    public function addAnnonce()
    {
        $this->validate([
            'image' => 'required|image|max:2048',
        ]);
        $annonce = new Annonce();
        if ($file = $this->image) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
            $imagePath = 'public/images/annonces/';
            /**
             * Delete an image if exists.
             */
            if($annonce->image){
                Storage::delete($imagePath . $annonce->image);
            }
            // Store an image to Storage
            $file->storeAs($imagePath, $fileName);
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

        $this->annonces = Annonce::all();
        session()->flash('message', 'Annonce added successfully.');
        return redirect()->back();
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
