<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnneeScolaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'annee_scolaire',
        'date_debut',
        'date_fin',
    ];

    // Accesseur pour générer automatiquement les dates de début et de fin
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $years = explode('-', $model->annee_scolaire);
            $model->date_debut = date("{$years[0]}-09-01"); // 1er septembre de la première année
            $model->date_fin = date("{$years[1]}-06-30"); // 30 juin de la seconde année
        });
    }

    
}

