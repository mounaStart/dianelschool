<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;

    protected $fillable = [

       
        'nom', 'prenom', 'adresse','numero_national','sexe', 'nationalite',
        'date_naissance','lieux_naissance', 'telephone1', 'telephone2','type_eleve','moyen_transport',
         'parent_id','classe_id','photo'
    ];
    public function classe()
    {
        return $this->belongsTo(Classe::class,'classe_id');
    }

    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }

    
   
    
 
public function parents()
{
    return $this->belongsTo(ParentEleve::class, 'parent_id');
}
 
public function parent()
{
    return $this->belongsTo(ParentEleve::class, 'parent_id');
}


    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    public function absences()
{
    return $this->hasMany(Absence::class);
}

    
}
