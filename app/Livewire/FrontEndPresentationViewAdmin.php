<?php

namespace App\Livewire;

use App\Models\FrontentPresentation;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class FrontEndPresentationViewAdmin extends Component
{

    use WithFileUploads;

    public $presentations;
    public $title;
    public $description;
    public $image;
    public $status;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function newPresentation(){
        $this->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
        ],
            [
            'title.required' => 'le titre est obligatoir.',
            'image.required' => 'The image field is required.',
            'image.image' => 'le fichier doit etre une image.',
            'image.mimes' => 'le format de l\'image doit etre parmi ceux ci: jpeg, png, jpg, gif, svg.',
            'image.max' => 'la taille de l\'image doit etre inferieur a 2 Mo .',
            'status.required' => 'le status est obligatoir.',
        ]);
        $presentations = new FrontentPresentation();
        $presentations->title = $this->title;
        $presentations->description = $this->description;
        $presentations->status = $this->status;
        
        if ($file = $this->image) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
            $imagePath = 'public/images/presentations/';
            /**
             * Delete an image if exists.
             */
            if($presentations->image){
                Storage::delete($imagePath . $presentations->image);
            }
            // Store an image to Storage
            $file->storeAs($imagePath, $fileName);
            $presentations->image = $fileName;
        }
        else{
            $presentations->image = '';
        }

        $presentations->save();
        session()->flash('message', 'Presentation Created Successfully.');
        return redirect()->route('frontend.admin');
    }

    public function editPresentation($id){
        $presentation = FrontentPresentation::find($id);
        $presentation->title = $this->title;
        $presentation->description = $this->description;
        $presentation->status = $this->status;
        if ($file = $this->image) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
            $imagePath = 'public/images/presentations/';
            /**
             * Delete an image if exists.
             */
            if($presentation->image){
                Storage::delete($imagePath . $presentation->image);
            }
            // Store an image to Storage
            $file->storeAs($imagePath, $fileName);
            $presentation->image = $fileName;
        }
        else{
            $presentation->image = '';
        }
        $presentation->save();
        session()->flash('message', 'Presentation Updated Successfully.');
        $this->dispatch('refreshComponent');
    }

    public function changeStatus($id){
        $presentation = FrontentPresentation::find($id);

        if($presentation->status == "actif"){
            $presentation->status = "inactif";
        }else{
            $presentation->status = "actif";
        }
        $presentation->save();
        session()->flash('message', 'Presentation Status Changed Successfully.');
        $this->dispatch('refreshComponent');
    }

    public function deletePresentation($id){
        $presentation = FrontentPresentation::find($id);
        $imagePath = 'public/images/presentations/';
        if($presentation->image){
            Storage::delete($imagePath . $presentation->image);
        }
        $presentation->delete();
        session()->flash('message', 'Presentation supprimée avec succès.');
        $this->dispatch('refreshComponent');
    }



    public function mount(){
        $this->presentations = FrontentPresentation::all();
    }
    public function render()
    {
        return view('livewire.front-end-presentation-view-admin');
    }
}
