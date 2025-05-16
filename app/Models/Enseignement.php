<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignement extends Model
{
    use HasFactory;

    // Table associée
    
    protected $table = 'enseignements';

    // Colonnes autorisées à être modifiées
    protected $fillable = [

       
        'nom', 'prenom','date_naissance' ,'sexe' ,'nationalite','telephone','email','lieux_naissance',
        'photo','proffesion','diplome','salaire','type_contrat','debut_contrat','fin_contrat' 
    ];
    public function cours()
    {
        return $this->hasMany(Cours::class);
    }

    /**
     * Relation avec le modèle Eleve (une classe a plusieurs élèves)
     */
  
public function user()
{
    return $this->belongsTo(User::class);
}


}
