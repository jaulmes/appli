<?php

namespace App\Console\Commands;

use App\Models\Suivi;
use App\Notifications\RappelRendezVous;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EnvoyerRappelsRendezVous extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rappels:rendezvous';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'envoyer des rappels de rendez-vous aux clients';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dateActuelle = Carbon::now();
        $suivis = Suivi::where('prochain_rendez_vous', '>=', $dateActuelle)
            ->where('prochain_rendez_vous', '<=', $dateActuelle->addMinutes(30))
            ->get();

        foreach ($suivis as $suivi) {
            $message = "Rappel de rendez-vous pour le client : {$suivi->clients->nom} le {$suivi->prochain_rendez_vous->format('d/m/Y H:i')}";
            $suivi->users->notify(new RappelRendezVous($suivi, $message));
        }

        $this->info('Rappels de rendez-vous envoyés avec succès.');
        return 0;
    }
}
