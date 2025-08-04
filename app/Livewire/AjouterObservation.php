<?php

namespace App\Livewire;

use App\Models\Observation;
use App\Models\Suivi;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AjouterObservation extends Component
{
    public $suivi;
    public $resume, $conclusion, $prochain_rendez_vous, 
            $besoins = [];

    protected $listeners = [
        'ajoutBesoin' => '$refresh',
    ];

    public function addBesoin(){
        $this->besoins[] = ['title' => ''];
        $this->dispatch('ajoutBesoin');
    }

    public function removeBesoin($index){
        unset($this->besoins[$index]);
        $this->besoins = $this->besoins; // Re-index the array
    }

    public function saveObservation($id)
    {
        
    DB::beginTransaction();

    try {
        // Récupérer le suivi concerné
        $suivi = Suivi::findOrFail($id);

        
        // Ajouter de nouveaux besoins au suivi
        foreach ($this->besoins as $besoin) {
            if (!empty($besoin['title'])) {
                $suivi->besoins()->create([
                    'titre' => $besoin['title'],
                    'suivi_id' => $suivi->id
                ]);
            }
        }

        
        // Valider les champs
        $this->validate([
            'resume' => 'required|min:1',
            'conclusion' => 'nullable|date',
            'prochain_rendez_vous' => 'nullable|date',
        ]);

        // Mise à jour du suivi
        $suivi->prochain_rendez_vous = $this->prochain_rendez_vous;
        $suivi->conclusion = $this->conclusion;
        $suivi->save();

        // Création de l'observation
        $observation = new Observation();
        $observation->resume = $this->resume;
        $observation->suivi_id = $suivi->id;
        $observation->save();

        // Enregistrement de la transaction
        $transaction = new Transaction();
        $transaction->user_id = Auth::id();
        $transaction->suivi_id = $suivi->id;
        $transaction->type = 'Ajout d\'observation';
        $transaction->save();

        // Valider la transaction
        DB::commit();

        // Réinitialiser les champs du formulaire
        $this->reset(['resume', 'conclusion', 'prochain_rendez_vous']);

        session()->flash('message', 'Observation ajoutée avec succès.');
        return redirect()->route('suivi.client');
    } catch (\Exception $e) {
        DB::rollBack();

        // Tu peux loguer l'erreur ou renvoyer un message d'erreur
        session()->flash('error', 'Une erreur est survenue lors de l\'ajout de l\'observation.');
        throw $e; // ou log($e)
    }
    }
    public function mount($suivi)
    {
        $this->besoins = [ 
            ['title' => '']
        ];
        $this->suivi = $suivi;
    }
    public function render()
    {
        return view('livewire.ajouter-observation');
    }
}
