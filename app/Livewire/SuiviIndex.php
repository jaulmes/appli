<?php

namespace App\Livewire;

use App\Models\Suivi;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    try {
        DB::beginTransaction();

        $suivi = Suivi::find($suivi_id);

        if (!$suivi) {
            session()->flash('error', 'Suivi non trouvé.');
            return;
        }
        // Enregistrement de la transaction
        $transaction = new Transaction();
        $transaction->user_id = Auth::id();
        $transaction->suivi_id = $suivi->id;
        $transaction->type = 'Suppression du suivi';
        $transaction->save();

        // Suppression du suivi
        $suivi->delete();

        // Mise à jour de la liste locale
        unset($this->observations[$suivi_id]);
        $this->suivis = collect($this->suivis)->filter(function ($item) use ($suivi_id) {
            return $item->id !== $suivi_id;
        })->values()->all();



        DB::commit();

        session()->flash('suppression', 'Suivi supprimé avec succès.');
        return redirect()->route('suivi.client'); // Redirection vers la liste des suivis
    } catch (\Exception $e) {
        DB::rollBack();
        session()->flash('error', 'Une erreur est survenue lors de la suppression.');
        // Optionnel : logger l'erreur pour debug
        // Log::error($e->getMessage());
        throw $e; // pour remonter l'erreur si nécessaire
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
