<?php

namespace App\Livewire;

use App\Models\Tache;
use App\Models\User;
use App\Notifications\AssigneTacheNotification;
use App\Notifications\statusNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
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
        
        $users = User::where('id', [$this->tache->created_by])->first();
        
        Tache::find($id)->update([
            'statut' => $this->statut,
        ]); 
        if(Auth::user()->id === $users->id){
            $realisateur = User::where('id', [$this->tache->assigned_to])->first();
            Notification::send($realisateur, new statusNotification($this->tache->titre));
        }else{
            Notification::send($users, new statusNotification($this->tache->titre));
        }

        $this->dispatch('modifierStatut');
        $this->dispatch('refreshTacheDetails');
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

        //envoye une notification a l'utilisateur a qui on a assigne la tache
        if($taches->assigned_to){
            $users = User::where('id', $this->user)->get();
            Notification::send($users, new AssigneTacheNotification($taches->titre));
        }


        $this->dispatch('modifierStatut');
        $this->dispatch('refreshTacheDetails');
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
