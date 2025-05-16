<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

 
class EmploiDuTemps extends Model
{
    use HasFactory;

    protected $table = 'emplois_du_temps';
    protected $fillable = ['date', 'heure_debut', 'heure_fin', 'classe_id', 'cours_id', 'enseignant_id', 'salle_id'];

    
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function enseignement()
    {
       
        return $this->belongsTo(Enseignement::class, 'enseignant_id');
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }
}
