<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithFileUploads;

class FrontEndModalEditServiceAdmin extends Component
{
    use WithFileUploads;
    public $service, $name, $description, $status, $image;


    public function mount($service)
    {
        $this->service = $service;
        $this->name = $service->name;
        $this->description = $service->description;
        $this->status = $service->status;

    }

    public function editService($serviceId){
        $service = Service::find($serviceId);
        if ($service) {
            $service->name = $this->name;
            $service->description = $this->description;
            $service->status = $this->status;

            if ($file = $this->image) {
                $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
                $imagePath = 'public/images/services/';

                // Store an image to Storage
                $file->storeAs($imagePath, $fileName);
                $service->image = $fileName;
            }
            else{
                $service->image = $service->image;
            }
            $service->save();
            return redirect()->route('frontend.admin')->with('successServices', 'Service mis a jour avec succes 👍.');
        }
        return redirect()->route('frontend.admin')->with('errorServices', 'Erreur lors de la mise a jour du service 😰.');
    }
    public function render()
    {
        return view('livewire.front-end-modal-edit-service-admin');
    }
}
