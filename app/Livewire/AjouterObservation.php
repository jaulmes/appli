<?php

namespace App\Livewire;

use App\Models\Observation;
use App\Models\Suivi;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
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
        
        //recuperer le suivi concerne
        $suivi = Suivi::find($id);

        //ajout de nouveaux besoins au suivi
        foreach($this->besoins as $besoin){
            if(!empty($besoin['title'])){
                $suivi->besoins()->create([
                    'titre' => $besoin['title'],
                    'suivi_id' => $suivi->id
                ]);
            }
        }

        $this->validate([
            'resume' => 'required|min:50',
            'conclusion' => 'nullable|date',
            'prochain_rendez_vous' => 'nullable|date',
        ]);

        $suivi->prochain_rendez_vous = $this->prochain_rendez_vous;
        $suivi->conclusion = $this->conclusion;
        $suivi->save();

        $observation = new Observation();
        $observation->resume = $this->resume;
        $observation->suivi_id = $suivi->id;
        $observation->save();

        $transaction = new Transaction();
        $transaction->user_id = Auth::user()->id;
        $transaction->suivi_id = $suivi->id;
        $transaction->type = 'Ajout d\'observation';
        $transaction->client_id = $suivi->client_id;
        $transaction->save();

        // Optionally, you can reset the form fields after saving
        $this->reset(['resume', 'conclusion', 'prochain_rendez_vous']);

        session()->flash('message', 'Observation ajoutée avec succès.');
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
