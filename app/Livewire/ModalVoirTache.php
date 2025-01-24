<?php

namespace App\Livewire;

use App\Models\Commentaire;
use App\Models\Tache;
use App\Models\User;
use App\Notifications\CommentaireNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class ModalVoirTache extends Component
{
    public $tache;

    public $comment;

    protected $listeners = ['refreshTacheDetails' => '$refresh'];

    public function ajouterCommentaire(){
        
        $utilisateurs = User::whereIn('id', [$this->tache->created_by, $this->tache->assigned_to])->get() ;

        $comment = new Commentaire();
        $comment->commentaire = $this->comment;
        $comment->tache_id = $this->tache->id;
        $comment->user_id = Auth::user()->id;
        $comment->save();

        Notification::send($utilisateurs, new CommentaireNotification($this->tache->titre));
        // Réinitialiser le champ de saisie
        $this->comment = '';

        // Actualiser les détails de la tâche
        $this->dispatch('refreshTacheDetails');
    }

    public function mount(Tache $tache){
        //$this->tache = $tache;
        $this->tache = Tache::with('commentaires.users')->findOrFail($tache->id);

    }
    public function render()
    {
        return view('livewire.modal-voir-tache');
    }
}
