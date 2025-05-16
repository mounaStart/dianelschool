<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Modèle : Paiement
class Paiement extends Model
{
    protected $fillable = ['facture_id', 'montant_paye', 'mode_paiement', 'date_paiement'];

    public function facture() {
        return $this->belongsTo(Facture::class);
    }
     // Événement pour mettre à jour le statut de la facture lors de l'ajout d'un paiement
     protected static function booted()
     {
         static::created(function ($paiement) {
             $paiement->facture->mettreAJourStatut();
         });
     }
}
