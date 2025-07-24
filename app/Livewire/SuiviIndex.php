<?php

namespace App\Livewire;

use App\Models\Suivi;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SuiviIndex extends Component
{

    public $suivis = [], $observations = [], $query = '', $filtreActif ="mes";

    public function getAllSuivis(){
        $this->suivis = Suivi::orderBy('created_at', 'desc')
                         ->get();
        foreach ($this->suivis as $suivi) {
            $this->observations[$suivi->id] = $suivi->observations()
                                                    ->orderBy('created_at', 'desc')
                                                    ->get();
        }
        $this->filtreActif = 'tous';
    }

    public function mesSuivis(){
        $user = Auth::user();
        $this->suivis = Suivi::where('user_id', $user->id)
                         ->orderBy('created_at', 'desc')
                         ->get();
        foreach ($this->suivis as $suivi) {
            $this->observations[$suivi->id] = $suivi->observations()
                                                    ->orderBy('created_at', 'desc')
                                                    ->get();
        }
        $this->filtreActif = 'mes';
        
    }
    

    public function supprimer($suivi_id)
    {
        $suivi = Suivi::find($suivi_id);
        if ($suivi) {
            $suivi->delete();
            unset($this->observations[$suivi_id]);
            $this->suivis = collect($this->suivis)->filter(function ($item) use ($suivi_id) {
                return $item->id !== $suivi_id;
            })->values()->all();
            session()->flash('suppression', 'Suivi supprimé avec succès.');
        } else {
            session()->flash('error', 'Suivi non trouvé.');
        }
    }

    public function mount(){
        $user = Auth::user();
        $this->suivis = Suivi::where('user_id', $user->id)
                         ->orderBy('created_at', 'desc')
                         ->get();
        foreach ($this->suivis as $suivi) {
            $this->observations[$suivi->id] = $suivi->observations()
                                                    ->orderBy('created_at', 'desc')
                                                    ->get();
        }
    }

    public function render()
    {
        return view('livewire.suivi-index');
    }
}
