<?php

namespace App\Livewire;

use App\Models\Tache;
use App\Models\User;
use App\Notifications\AssignerTache;
use App\Notifications\AssigneTacheNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class ModalCreerTache extends Component
{
    public $user;
    public $titre;
    public $description;
    public $statut = '';
    public $etat = 'non assigne';
    public $date_debut;
    public $date_fin;


    public function assigned_user(){
        $this->user;
    }

    public function statut(){
        $this->statut;
    }

    public function save(){
        $taches = new Tache();

        $taches->titre = $this->titre;
        $taches->description = $this->description;
        $taches->created_by = Auth::user()->id;
        $taches->statut = $this->statut;
        $taches->assigned_to = $this->user;
        $taches->date_debut = $this->date_debut;
        $taches->date_fin = $this->date_fin;
        if($taches->assigned_to){
            $taches->etat = "assigne";
            
        }else{
            $taches->etat = "non assigne";
        }
        
        $taches->save();
        //envoye une notification a l'utilisateur a qui on a assigne la tache
        if($taches->assigned_to){
            $users = User::where('id', $this->user)->get();
            Notification::send($users, new AssigneTacheNotification($taches->titre));
        }
        redirect()->to('taches/index');
        $this->dispatch('tacheAjoute');
    }
    public function render()
    {
        $users = User::all();
        return view('livewire.modal-creer-tache', compact('users'));
    }
}
