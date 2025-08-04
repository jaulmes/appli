<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Observation;
use App\Models\Suivi;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class AddSuivi extends Component
{
    public $suivi, $clients, $nouveau_client = false, 
        $besoins = [], $nom_nouveau_client, $client_id,
        $email_nouveau_client, $numero_nouveau_client, 
        $adresse_client, $prochain_rendez_vous, 
        $date_conclusion, $resume;

    public function addBesoin(){
        $this->besoins[] = ['title' => ''];
    }

    public function removeBesoin($index){
        unset($this->besoins[$index]);
        $this->besoins = $this->besoins; // Re-index the array
    }

    public function saveSuivi(){

        DB::beginTransaction();

        try{

            if($this->nouveau_client){
                $clients = new Client();
                $clients->nom = $this->nom_nouveau_client;
                $clients->email = $this->email_nouveau_client;
                $clients->numero = $this->numero_nouveau_client;
                $clients->adresse = $this->adresse_client;
                $clients->save();
            } else {
                $clients = Client::find($this->client_id);
            }

            //user
            $users = Auth::user();
            $user_id = $users->id;
            //suivi
            $suivi = new Suivi();
            $suivi->client_id = $clients->id;
            $suivi->user_id = $user_id;
            $suivi->conclusion = $this->date_conclusion;
            $suivi->prochain_rendez_vous = $this->prochain_rendez_vous;
            $suivi->save();

            //besoins
            foreach($this->besoins as $besoin){
                if(!empty($besoin['title'])){
                    $suivi->besoins()->create([
                        'titre' => $besoin['title'],
                        'suivi_id' => $suivi->id
                    ]);
                }
            }

            //observations
            $observations = new Observation();
            $observations->suivi_id = $suivi->id;
            $observations->resume = $this->resume;
            $observations->save();

            //transaction
            $transactions = new Transaction();
            $transactions->suivi_id = $suivi->id;
            $transactions->type = "ajout d'un nouvreau suivi";
            $transactions->user_id = $user_id;
            $transactions->save();

            Notification::send($users, new \App\Notifications\RappelRendezVous($suivi, 'Un nouveau suivi a été créé pour vous.'));
            DB::commit(); 

            session()->flash('message', 'Suivi saved successfully.');
            return redirect()->route('suivi.client');
        }catch(Exception $e){
            DB::rollBack(); // En cas d'erreur, on annule tout
    
            return redirect()->back()->with('error', 'Une erreur s\'est produite : ' . $e->getMessage());
        }
    }
    

    public function handle_client(){
        $this->nouveau_client = !$this->nouveau_client;
    }

    public function mount(){
        $this->besoins = [ 
            ['title' => '']
        ];
        $this->clients = Client::all();
    }
    public function render()
    {
        return view('livewire.add-suivi');
    }
}
