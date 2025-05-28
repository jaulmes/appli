<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithFileUploads;

class FrontEndServiceAdmin extends Component
{

    use WithFileUploads;
    public $services = [], $name, $description, $status, $image; 

    public function mount(){
        $this->services = Service::all();
    }

    public function createService(){
        $services = new Service();

        $services->name = $this->name;
        $services->description = $this->description;
        $services->status = $this->status;
        if ($file = $this->image) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
            $imagePath = 'images/services/';

            // Store an image to Storage
            $file->storeAs($imagePath, $fileName, 'real_public');
            $services->image = $fileName;
        }
        else{
            $services->image = '';
        }
        $services->save();
        $this->reset(['name', 'description', 'status', 'image']);
        return redirect()->route('frontend.admin')->with('successServices', 'Service cree avec succes 👍.');
    }

    public function deleteService($id){
        $service = Service::find($id);
        if ($service) {
            $service->delete();
            return redirect()->route('frontend.admin')->with('deleteServices', 'Service supprime avec succes 😡.');
        }
        return redirect()->route('frontend.admin')->with('errorServices', 'Erreur lors de la suppression du service 😰.');
    }

    public function updateStatus($id){
        $service = Service::find($id);
        if ($service->status == 'actif') {
            $service->status = 'inactif';
        }else{
            $service->status = 'actif';
        }

        $service->save();
        return redirect()->route('frontend.admin')->with('updateStatusServices', 'statut du service mis a jour avec succes 👍.');

    }
    
    public function render()
    {
        return view('livewire.front-end-service-admin');
    }
}
