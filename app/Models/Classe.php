<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    // Table associée
    protected $table = 'classes';

    // Colonnes autorisées à être modifiées
    protected $fillable = ['nom', 'niveau'];

    /**
     * Relation avec le modèle Eleve (une classe a plusieurs élèves)
     */
    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    }
    public function cours()
{
    return $this->hasMany(Cours::class);
}
   // Relation avec EmploiDuTemps
   public function emploiDuTemps()
   {
       return $this->hasOne(EmploiDuTemps::class, 'classe_id');
   }
   public function evaluations()
{
    return $this->hasMany(Evaluation::class);
}




}
