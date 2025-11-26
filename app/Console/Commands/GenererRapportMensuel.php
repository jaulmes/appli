<?php

namespace App\Console\Commands;

use App\Models\Compte;
use App\Models\SoldeCompteMensuel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenererRapportMensuel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rapport:mensuel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génère le rapport mensuel des activités';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $comptes = Compte::all();

        $dateActuelle = Carbon::now()->startOfMonth()->toDateString(); 
        $datePasse = Carbon::now()->subMonth()->startOfMonth()->toDateString();

        foreach ($comptes as $compte) {

            // 1. On récupère l'état du mois passé
            $etatComptePasse = SoldeCompteMensuel::where('date_capture', $datePasse)
                                                ->where('compte_id', $compte->id)
                                                ->first();

            // 2. S'il n'existe pas, on le crée
            if (!$etatComptePasse) {
                $etatComptePasse = SoldeCompteMensuel::create([
                    'compte_id'   => $compte->id,
                    'solde_debut' => $compte->montant,   // ou 0 selon ta logique
                    'solde_fin'   => $compte->montant,
                    'date_capture'=> $datePasse
                ]);
            } else {
                // On met simplement à jour le solde de fin
                $etatComptePasse->solde_fin = $compte->montant;
                $etatComptePasse->save();
            }

            // 3. On crée le rapport du mois actuel
            SoldeCompteMensuel::create([
                'compte_id'   => $compte->id,
                'solde_debut' => $etatComptePasse->solde_fin,
                'solde_fin'   => null, // pour le moment
                'date_capture'=> $dateActuelle
            ]);
        }
    }
}
