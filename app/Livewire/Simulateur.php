<?php

namespace App\Livewire;

use App\Models\AppareilSimulation;
use App\Models\ClientSimuleur;
use App\Models\Simulation;
use App\Models\Simuleur;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class Simulateur extends Component
{
    public $appareils = [], $coeficient_securite = 20, 
            $tension_entre_panneau = 12, $ensoleillement_site = 4.3,
            $efficacite_installation = 79, $autonomie_generale = 1.5, 
            $tension_batterie = 12, $tension_sortie_batterie = 12, 
            $DOD_batterie = 75, $energie_totale = 0, 
            $besoin_energetique_journalier, $unite_batterie, 
            $batteri_souhaite, $nombre_watt_panneaux,
            $nombre_panneaux, $puissance_champ_panneaux,
            $capacite_batterie, $nombre_batteries, 
            $courant_minimun_controlleur, $puissance_convertisseur,
            $unite_capacite_batterie, $convertisseur_type,
            $nom_simuleur, $numero_telephone_simuleur, $email_simuleur,
            $adresse_simuleur, $nom_client, $numero_telephone_client, 
            $email_client, $adresse_client;
    public bool $showResults = false;

    public function mount()
    {
        // Initialiser un premier appareil vide
        $this->appareils = [
            ['name'=>'', 'quantity', 'power', 'duration']
        ];
    }

    public function ajouterAppareil()
    {
        $this->appareils[] = ['name'=>'', 'quantity', 'power', 'duration'];
    }

    public function retirerAppareil($index)
    {
        unset($this->appareils[$index]);
        $this->appareils = array_values($this->appareils);
    }

    protected $rules = [
        'appareils.*.name'          => 'required|string|max:255',
        'appareils.*.quantity'      => 'required|integer|min:1',
        'appareils.*.power'         => 'required|numeric|min:0',
        'appareils.*.duration'      => 'required|numeric|min:0',
        'coeficient_securite'       => 'required|numeric|min:0',
        'tension_entre_panneau'     => 'required|numeric|min:0',
        'ensoleillement_site'       => 'required|numeric|min:0',
        'efficacite_installation'   => 'required|numeric|min:1',
        'autonomie_generale'        => 'required|numeric|min:1',
        'tension_batterie'          => 'required|numeric|min:12',
        'tension_sortie_batterie'   => 'required|numeric|min:0',
        'DOD_batterie'              => 'required|numeric|min:0',
        'nombre_watt_panneaux'      => 'required|numeric|min:0',
        'unite_batterie'            => 'required|in:Ah,Wh',
        'batteri_souhaite'          => 'required|numeric|min:0',
    ];

    protected  $messages =
        [
            'appareils.*.name.required'     => 'Le nom de l’appareil est obligatoire.',
            'appareils.*.quantity.required' => 'La quantité est obligatoire.',
            'appareils.*.quantity.integer'  => 'La quantité doit être un entier.',
            'appareils.*.quantity.min'      => 'La quantité doit être au moins 1.',
            'appareils.*.power.required'    => 'La puissance est obligatoire.',
            'appareils.*.power.min'         => 'La puissance doit être positive.',
            'appareils.*.duration.required' => 'La durée est obligatoire.',
            'appareils.*.duration.min'      => 'La durée doit être positive.',
            'nombre_watt_panneaux'          => 'Le nombre de watt des panneaux est obligatoire.',
            'unite_batterie'                => 'L’unité de la batterie est obligatoire. veuillez choisir entre Ah ou Wh',
            'batteri_souhaite'              => "Le nombre d'ampere ou de watt est obligatoire.",
            // … messages pour les autres paramètres
        ];
    public function handleUniteBatterie(){
        if($this->unite_batterie == 'Ah'){
            $this->unite_batterie = 'Ah';
        }else{
            $this->unite_batterie = 'Wh';
        }
    }

    public function handleTypeConvertisseur(){
        if($this->convertisseur_type == 'pure_sinus'){
            $this->convertisseur_type = 'pure_sinus';
        }else{
            $this->convertisseur_type = 'sinus_modifie';
        }
    }

    public function simuller(){
        
        $validated = $this->validate();

        // Réinitialiser les valeurs calculées
        $this->energie_totale = 0;
        $this->besoin_energetique_journalier = 0;
        $this->puissance_champ_panneaux = 0;
        $this->nombre_panneaux = 0;
        $this->capacite_batterie = 0;
        $this->unite_capacite_batterie = '';
        $this->nombre_batteries = 0;
        $this->courant_minimun_controlleur = 0;
        $this->puissance_convertisseur = 0;
        
        // Logique de simulation ici
        $total_puissance_totale = 0;
        // Par exemple, calculer l'energie totale des appareils en wh/jour et puissance totale
        foreach ($this->appareils as $appareil) {
            $total_puissance_totale += $appareil['power'] * $appareil['quantity'];
            $this->energie_totale += $appareil['power'] * $appareil['quantity'] * $appareil['duration'];
        }
        //besoin_energetique_journalier
        $this->besoin_energetique_journalier = $this->energie_totale * (1 + ($this->coeficient_securite / 100));
        
        //puissance_champ_panneaux
        $this->puissance_champ_panneaux = $this->besoin_energetique_journalier / ($this->ensoleillement_site * $this->efficacite_installation / 100);

        // nombre_watt_panneaux
        $this->nombre_panneaux = $this->puissance_champ_panneaux / $this->nombre_watt_panneaux;

        //capacite_batterie
        if($this->unite_batterie == 'Ah'){
            $this->capacite_batterie = ($this->besoin_energetique_journalier * $this->autonomie_generale) / ($this->tension_batterie * ($this->DOD_batterie / 100));
            $this->unite_capacite_batterie = 'Ah';
        }else{
            $this->capacite_batterie = ($this->besoin_energetique_journalier * $this->autonomie_generale) / ($this->DOD_batterie / 100);
            $this->unite_capacite_batterie = 'Wh';
        }

        //nombre_batteries
        $this->nombre_batteries = $this->capacite_batterie / $this->batteri_souhaite;
        
        //courant_minimun_controlleur
        $this->courant_minimun_controlleur = $this->puissance_champ_panneaux / $this->tension_sortie_batterie;

        //convertisseur_type
        if($this->convertisseur_type == 'pure_sinus') {
            //puissance_convertisseur
            $this->puissance_convertisseur = 5/2 * $total_puissance_totale;
        } else {
            //puissance_convertisseur
            $this->puissance_convertisseur = 4 * $total_puissance_totale;
        }
        
        $this->showResults = true;
    }

    public function generatePdf(){
        // Valider les données avant de générer le PDF
        $this->validate([
            'nom_simuleur' => 'required|string|max:255',
            'numero_telephone_simuleur' => 'required|string|max:20',
        ]);
        //message d'erreur des données du client
        $this->validate([
            'nom_simuleur.required' => 'votre nom est obligatoire.',
            'numero_telephone_simuleur.required' => 'Votre numéro de téléphone est obligatoire.',

        ]);
        //enregistrer le simuleur(celui qui simule)
        $simuleur = new Simuleur();
        $simuleur->nom = $this->nom_simuleur;
        $simuleur->numero = $this->numero_telephone_simuleur;
        $simuleur->adresse = $this->adresse_simuleur;
        $simuleur->save();
        //enregistrer le client(le client de celui qui simule)
        if($this->nom_client != null){
            $client = ClientSimuleur::where('nom', $this->nom_client)
                        ->where('numero', $this->numero_telephone_client)
                        ->first();
            if(!$client){
                $client = new ClientSimuleur();
                $client->nom = $this->nom_client;
                $client->numero = $this->numero_telephone_client;
                $client->adresse = $this->adresse_client;
                $client->save();
            }
            $simuleur->save();
            
        }
        //enregistrer la simulation
        $simulation = new Simulation();
        $simulation->appareils = json_encode($this->appareils);
        $simulation->coeficient_securite = $this->coeficient_securite;
        $simulation->tension_entre_panneau = $this->tension_entre_panneau;
        $simulation->ensoleillement_site = $this->ensoleillement_site;
        $simulation->efficacite_installation = $this->efficacite_installation;
        $simulation->autonomie_generale = $this->autonomie_generale;
        $simulation->tension_batterie = $this->tension_batterie;
        $simulation->tension_sortie_batterie = $this->tension_sortie_batterie;
        $simulation->DOD_batterie = $this->DOD_batterie;
        $simulation->energie_totale = $this->energie_totale;
        $simulation->besoin_energetique_journalier = $this->besoin_energetique_journalier;
        $simulation->unite_batterie = $this->unite_batterie;
        $simulation->batteri_souhaite = $this->batteri_souhaite;
        $simulation->nombre_watt_panneaux = $this->nombre_watt_panneaux;
        $simulation->nombre_panneaux = $this->nombre_panneaux;
        $simulation->puissance_champ_panneaux = $this->puissance_champ_panneaux;
        $simulation->capacite_batterie = $this->capacite_batterie;
        $simulation->nombre_batteries = $this->nombre_batteries;
        $simulation->courant_minimun_controlleur = $this->courant_minimun_controlleur;
        $simulation->puissance_convertisseur = $this->puissance_convertisseur;
        $simulation->unite_capacite_batterie = $this->unite_capacite_batterie;
        $simulation->simuleur_id = $simuleur->id;
        if($this->nom_client){
            $simulation->client_simuleur_id = $client->id;
        }

        $simulation->save();

        //enregistrer les appareil liés a la simulation
        foreach($this->appareils as $element){
            $appareil = new AppareilSimulation();
            $appareil->name = $element['name'];
            $appareil->quantity = $element['quantity'];
            $appareil->power = $element['power'];
            $appareil->duration = $element['duration'];
            $appareil->simulation_id = $simulation->id;
            $appareil->save();
        }
        // Générer le PDF avec les données de simulation
        $pdf = Pdf::loadView('frontend.page.rapport-simulation', [
            'appareils' => $this->appareils,
            'coeficient_securite' => $this->coeficient_securite,
            'tension_entre_panneau' => $this->tension_entre_panneau,
            'ensoleillement_site' => $this->ensoleillement_site,
            'efficacite_installation' => $this->efficacite_installation,
            'autonomie_generale' => $this->autonomie_generale,
            'tension_batterie' => $this->tension_batterie,
            'tension_sortie_batterie' => $this->tension_sortie_batterie,
            'DOD_batterie' => $this->DOD_batterie,
            'energie_totale' => $this->energie_totale,
            'besoin_energetique_journalier' => $this->besoin_energetique_journalier,
            'unite_batterie' => $this->unite_batterie,
            'batteri_souhaite' => $this->batteri_souhaite,
            'nombre_watt_panneaux' => $this->nombre_watt_panneaux,
            'nombre_panneaux' => $this->nombre_panneaux,
            'puissance_champ_panneaux' => $this->puissance_champ_panneaux,
            'capacite_batterie' => $this->capacite_batterie,
            'nombre_batteries' => $this->nombre_batteries,
            'courant_minimun_controlleur' => $this->courant_minimun_controlleur,
            'puissance_convertisseur' => $this->puissance_convertisseur,
            'unite_capacite_batterie' => $this->unite_capacite_batterie
        ]);
        return response()->streamDownload(function () use($pdf) {
            echo  $pdf->output();
        }, 'report_simulation_'.$simuleur->nom.'_'.$simuleur->numero.'.pdf');
    }

    public function render()
    {
        return view('livewire.simulateur');
    }
}
