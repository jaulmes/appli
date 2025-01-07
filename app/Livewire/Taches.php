<?php

namespace App\Livewire;

use App\Models\Tache;
use App\Models\User;
use Livewire\Component;

use function React\Promise\all;

class Taches extends Component
{
    public $taches = [];
    public $statut;

    protected $listeners = ['tacheAjoute' => 'updateTache'];
    public function mount(){
        $this->taches = Tache::all();
    }

    public function updateTache(){
        $this->taches;
    }

    public function deleteTache($id){
        $taches = Tache::find($id)->delete();
        $this->taches = Tache::all();
    }

    public function updateAssigne($tache_id, $user_id){
        //je recupere la tache
        $taches = Tache::find($tache_id);
        //je recupere l'utilisateur chez qui je souhaites attribuer la tache
        $users = User::find($user_id);

        //j'attribut la tache a un nouvel utilisateur et je change le statut
        $taches->assigned_to = $users->id;
        $taches->etat = "assigne";
        $taches->save();
        $this->taches = Tache::all();
    }


    
    public function render()
    {
        $users = User::all();
        return view('livewire.taches', compact('users'));
    }
}
