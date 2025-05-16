<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Facture;

class RappelPaiementMail extends Mailable
{
    use Queueable, SerializesModels;

    public $facture;

    public function __construct(Facture $facture)
    {
        $this->facture = $facture;
    }

    public function build()
    {
        return $this->subject('Rappel de Paiement - RimSchool')
                    ->view('emails.rappel_paiement');
    }
}
