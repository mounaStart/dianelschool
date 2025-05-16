<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Modèle : FraisScolaire
class FraisScolaire extends Model
{
    protected $fillable = ['nom', 'montant', 'classe_id','description'];

    public function classe() {
        return $this->belongsTo(Classe::class);
    }
    public function factures()
{
    return $this->belongsToMany(Facture::class, 'facture_frais', 'frais_id', 'facture_id');
}

}
