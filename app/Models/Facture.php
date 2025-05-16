<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Modèle : Facture
class Facture extends Model
{
    protected $fillable = ['eleve_id', 'montant_total', 'statut', 'date_emission', 'date_echeance'];
    
    public static function boot()
    {
        parent::boot();

        static::creating(function ($facture) {
            // Assigner la date d'émission à la date actuelle si elle n'est pas fournie
            if (!$facture->date_emission) {
                $facture->date_emission = now();
            }

            // Calculer la date d'échéance : 30 jours après la date d'émission (exemple)
            $facture->date_echeance = now()->addDays(5); // Tu peux ajuster cette logique
        });
    }
    public function eleve() {
        return $this->belongsTo(Eleve::class);
    }

    public function paiements() {
        return $this->hasMany(Paiement::class);
    }
     
     
    public function frais()
    {
        return $this->belongsToMany(FraisScolaire::class, 'facture_frais', 'facture_id', 'frais_scolaires_id');
    }
     

    // Pour récupérer le montant total payé
    public function getMontantTotalPayeAttribute()
    {
        return $this->paiements->sum('montant_paye');
    }

    // Pour calculer le statut de la facture dynamiquement
    public function getStatutAttribute()
    {
        if ($this->getMontantTotalPayeAttribute() == 0) {
            return 'non payé';
        } elseif ($this->getMontantTotalPayeAttribute() < $this->montant_total) {
            return 'partiellement payé';
        } else {
            return 'payé';
        }
    }
    // Méthode pour vérifier si la facture est payée
    public function estPaye()
    {
        return $this->statut === 'payé';
    }
    // Méthode pour calculer le montant total payé
    public function montantTotalPaye()
    {
        return $this->paiements->sum('montant_paye');
    }
     // Méthode pour mettre à jour le statut automatiquement
     public function mettreAJourStatut()
     {
         if ($this->montantTotalPaye() >= $this->montant_total) {
             $this->update(['statut' => 'payé']);
         }
         elseif ($this->montantTotalPaye() < $this->montant_total) {
            return 'partiellement payé';
            $this->update(['statut' => 'partiellement payé']);
        } 
        else {
            return 'En attente';
            $this->update(['statut' => 'En attente']);
        }
     }


}
