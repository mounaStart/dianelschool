<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $fillable = ['classe_id', 'matiere_id', 'enseignement_id'];

    // Relation avec Classe
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    // Relation avec Matiere
    public function matiere()
    {
        return $this->belongsTo(Matier::class); // Assurez-vous que le nom de la classe est correct.
    }

    // Relation avec Enseignant
    public function enseignement()
    {
        return $this->belongsTo(Enseignement::class);
    }
}
