<?php

namespace App\Livewire;

use App\Models\Pack;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPackAdmin extends Component
{
    use WithFileUploads;

    public $pack =[], $newImage, 
            $description, $prix, $titre;

    public function editPack($id){
        $pack = Pack::find($id);
        $pack->titre =$this->titre;
        $pack->description =$this->description;
        $pack->prix = $this->prix;

        if ($this->newImage) {
            $fileName = hexdec(uniqid()).'.'.$this->newImage->getClientOriginalName();
            $imagePath = 'images/packs/';
            /**
             * Delete an image if exists.
             */
            if($pack->image){
                Storage::delete($imagePath . $pack->image);
            }
            // Store an image to Storage
            $this->newImage->storeAs($imagePath, $fileName, 'real_public');
            $pack->image = $fileName;
        }
        else{
            $pack->image = $pack->image;
        }
        $pack->save();

        return redirect()->route('frontend.admin');

    }

    public function mount(Pack $pack){
        $this->pack = $pack;
        $this->titre = $pack->titre;
        $this->description = $pack->description;
        $this->prix = $pack->prix;
    }

    public function render()
    {
        return view('livewire.edit-pack-admin');
    }
}
