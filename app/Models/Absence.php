<?php

 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = ['eleve_id', 'date', 'type', 'motif'];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }
}
