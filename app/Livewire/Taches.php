<?php

namespace App\Livewire;

use App\Models\Tache;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use function React\Promise\all;

class Taches extends Component
{
    public $taches = [];
    public $statut;
    public $tacheId;

    protected $listeners = ['tacheAjoute' => 'updateTache',
                            'modifierStatut' => 'mesTaches'];
    public function mount(){
        $this->mesTaches();
    }

    public function mesTaches(){
        $user_id = Auth::user()->id;
        $this->taches = Tache::where('assigned_to', $user_id)->get();
    }

    public function updateTache(){
        $this->taches;
    }
    
    public function allTaches(){
        $this->taches = Tache::all();
    }

    public function render()
    {
        $users = User::all();
        return view('livewire.taches', compact('users'));
    }
}
