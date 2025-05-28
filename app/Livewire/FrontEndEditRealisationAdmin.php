<?php

namespace App\Livewire;

use App\Models\Realisation;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class FrontEndEditRealisationAdmin extends Component
{
    use WithFileUploads; 
    public $realisation, $image;
    public $titre, $description, $status, $img1, $img2, $img3, $img4, $img5;

    public function mount(Realisation $realisation)
    {
        $this->realisation = $realisation;
        $this->titre = $realisation->titre;
        $this->description = $realisation->description;
        $this->status = $realisation->status;
    }

    public function editRealisation($realisationId)
    {
        
        $realisation = Realisation::find($realisationId);
        
        $realisation->titre = $this->titre;
        $realisation->description = $this->description;
        $realisation->status = $this->status;
        
        if ($file = $this->img1) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
            $imagePath = 'images/Realisations/';

            // Store an image to Storage
            $file->storeAs($imagePath, $fileName, 'real_public');
            $realisation->img1 = $fileName;
        }
        else{
            $realisation->img1 = $realisation->img1;
        }

        if ($file = $this->img2) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
            $imagePath = 'images/Realisations/';

            // Store an image to Storage
            $file->storeAs($imagePath, $fileName, 'real_public');
            $realisation->img2 = $fileName;
        }
        else{
            $realisation->img2 = $realisation->img2;
        }

        if ($file = $this->img3) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
            $imagePath = 'images/Realisations/';

            // Store an image to Storage
            $file->storeAs($imagePath, $fileName, 'real_public');
            $realisation->img3 = $fileName;
        }
        else{
            $realisation->img3 = $realisation->img3;
        }

        if ($file = $this->img4) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
            $imagePath = 'images/Realisations/';

            // Store an image to Storage
            $file->storeAs($imagePath, $fileName, 'real_public');
            $realisation->img4 = $fileName;
        }
        else{
            $realisation->img4 = $realisation->img4;
        }

        if ($file = $this->img5) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
            $imagePath = 'images/Realisations/';

            // Store an image to Storage
            $file->storeAs($imagePath, $fileName, 'real_public');
            $realisation->img5 = $fileName;
        }
        else{
            $realisation->img5 = $realisation->img5;
        }
        

        $realisation->save();
        session()->flash('message_realisation', 'realisation Updated Successfully.');
        return redirect()->route('frontend.admin');
    }

    public function render()
    {
        return view('livewire.front-end-edit-realisation-admin');
    }
}
