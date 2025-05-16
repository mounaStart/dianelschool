<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentEleve extends Model
{
    use HasFactory;

    // Table associée
    protected $table = 'parents';

    // Colonnes autorisées à être modifiées
    protected $fillable = [ 'prenom','nom' ,'relation','telephone', 'email'];

    /**
     * Relation avec le modèle Eleve (un parent peut avoir plusieurs élèves)
     */
     
    //     public function eleves()
    // {
    //     return $this->hasMany(Eleve::class, 'parent_id');
    // }
    public function eleves()
    {
        return $this->hasMany(Eleve::class, 'parent_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
  

public function enfants()
{
    return $this->hasMany(Eleve::class, 'parent_id');
}
}
