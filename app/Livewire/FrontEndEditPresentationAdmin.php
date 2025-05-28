<?php

namespace App\Livewire;

use App\Models\FrontentPresentation;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class FrontEndEditPresentationAdmin extends Component
{
    use WithFileUploads; 
    public $presentation, $image;
    public $titre, $description, $status;

    public function mount(FrontentPresentation $presentation)
    {
        $this->presentation = $presentation;
        $this->titre = $presentation->title;
        $this->description = $presentation->description;
        $this->status = $presentation->status;
    }

    public function editPresentation($presentationId)
    {
        
        $presentation = FrontentPresentation::find($presentationId);
        
        $presentation->title = $this->titre;
        $presentation->description = $this->description;
        $presentation->status = $this->status;
        
        if ($this->image) {
            $fileName = hexdec(uniqid()).'.'.$this->image->getClientOriginalName();
            $imagePath = 'images/presentations/';
            /**
             * Delete an image if exists.
             */
            if($presentation->image){
                Storage::delete($imagePath . $presentation->image);
            }
            // Store an image to Storage
            $this->image->storeAs($imagePath, $fileName, 'real_public');
            $presentation->image = $fileName;
        }
        else{
            $presentation->image = $presentation->image;
        }

        $presentation->save();
        session()->flash('message_presentation', 'Presentation Updated Successfully.');
        return redirect()->route('frontend.admin');
    }
    
    
    public function render()
    {
        return view('livewire.front-end-edit-presentation-admin');
    }
}
