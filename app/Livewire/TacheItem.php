<?php

namespace App\Livewire;

use App\Models\Tache;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TacheItem extends Component
{
    public $tache;
    public $statut;
    public function mount(Tache $tache)
    {
        $this->tache = $tache;
    }

    public function updateStatut($id){
        Tache::find($id)->update([
            'statut' => $this->statut,
        ]); 

        $this->dispatch('modifierStatut');
        return redirect()->with('message', 'status de la tache mis a jour');
    }

    public function deleteTache($id){
        $taches = Tache::find($id)->delete();
        $this->dispatch('modifierStatut');

    }

    public function updateAssigne( $tache_id, $user_id){
        //je recupere la tache
        $taches = Tache::find($tache_id);
        //je recupere l'utilisateur chez qui je souhaites attribuer la tache
        $users = User::find($user_id);

        //j'attribut la tache a un nouvel utilisateur et je change le statut
        $taches->assigned_to = $users->id;
        $taches->etat = "assigne";
        $taches->save();
        $this->dispatch('modifierStatut');
    }

    public function showTache($id){
        $this->tache = Tache::find($id);
        $this->dispatch('voirTache');
    }

    public function render()
    {
        $users = User::all();
        return view('livewire.tache-item', compact('users'));
    }
}
