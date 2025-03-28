<?php

namespace App\Livewire;

use App\Models\Realisation;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class FrontEndRealisationAdmin extends Component
{
    use WithFileUploads;

    public $realisations;
    public $titre;
    public $description;
    public $img1, $img2, $img3, $img4, $img5;
    public $status, $date;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function newRealisation(){
        DB::beginTransaction();

        try{
            $this->validate([
                'titre' => 'required',
                'status' => 'required',
            ],
                [
                'titre.required' => 'le titre est obligatoir.',
                'status.required' => 'le status est obligatoir.',
            ]);
            $realisations = new Realisation();
            $realisations->titre = $this->titre;
            $realisations->description = $this->description;
            $realisations->status = $this->status;
            $realisations->date = $this->date;
            
            if ($file = $this->img1) {
                $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
                $imagePath = 'public/images/Realisations/';
    
                // Store an image to Storage
                $file->storeAs($imagePath, $fileName);
                $realisations->img1 = $fileName;
            }
            else{
                $realisations->img1 = '';
            }
    
            if ($file = $this->img2) {
                $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
                $imagePath = 'public/images/Realisations/';
    
                // Store an image to Storage
                $file->storeAs($imagePath, $fileName);
                $realisations->img2 = $fileName;
            }
            else{
                $realisations->img2 = '';
            }
    
            if ($file = $this->img3) {
                $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
                $imagePath = 'public/images/Realisations/';
    
                // Store an image to Storage
                $file->storeAs($imagePath, $fileName);
                $realisations->img3 = $fileName;
            }
            else{
                $realisations->img3 = '';
            }
    
            if ($file = $this->img4) {
                $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
                $imagePath = 'public/images/Realisations/';
    
                // Store an image to Storage
                $file->storeAs($imagePath, $fileName);
                $realisations->img4 = $fileName;
            }
            else{
                $realisations->img4 = '';
            }
    
            if ($file = $this->img5) {
                $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalName();
                $imagePath = 'public/images/Realisations/';
    
                // Store an image to Storage
                $file->storeAs($imagePath, $fileName);
                $realisations->img5 = $fileName;
            }
            else{
                $realisations->img5 = '';
            }
            $realisations->save();
            session()->flash('message', 'Realisation Created Successfully.');

            DB::commit();

            return redirect()->route('frontend.admin');
        }catch(Exception $e){
            DB::rollBack(); // En cas d'erreur, on annule tout
    
            return redirect()->back()->with('error', 'Une erreur s\'est produite : ' . $e->getMessage());
        }
        
    }

    public function changeStatus($id){
        $realisations = Realisation::find($id);

        if($realisations->status == "actif"){
            $realisations->status = "inactif";
        }else{
            $realisations->status = "actif";
        }
        $realisations->save();
        session()->flash('message', 'Realisation Status Changed Successfully.');
        $this->dispatch('refreshComponent');
    }

    public function deleteRealisation($id){
        $realisations = Realisation::find($id);
        $imagePath = 'public/images/Realisations/';
        if($realisations->image){
            Storage::delete($imagePath . $realisations->image);
        }
        $realisations->delete();
        session()->flash('message', 'Realisation supprimée avec succès.');
        $this->dispatch('refreshComponent');
    }
    public function mount(){
        $this->realisations = Realisation::all();
    }
    
    public function render()
    {
        return view('livewire.front-end-realisation-admin');
    }
}
