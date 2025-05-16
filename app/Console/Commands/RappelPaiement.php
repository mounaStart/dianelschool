<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Facture;
use App\Mail\RappelPaiementMail;
use Carbon\Carbon;
use Mail;

class RappelPaiement extends Command
{
    protected $signature = 'rappel:paiement';
    protected $description = 'Envoie des rappels de paiement pour les factures en retard';

    public function handle()
    {
        $aujourdhui = Carbon::now()->toDateString();

        $factures = Facture::where('date_echeance', '<', $aujourdhui)
                            ->where('statut', 'impayée')
                            ->with('eleve')
                            ->get();

        foreach ($factures as $facture) {
            $eleve = $facture->eleve;
            Mail::to($eleve->email)->send(new RappelPaiementMail($facture));

            $this->info("Rappel envoyé à : {$eleve->prenom} {$eleve->nom}");
        }

        $this->info('Tous les rappels ont été envoyés avec succès.');
    }
}
