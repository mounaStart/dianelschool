<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Matier;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = ['titre', 'date', 'classe_id', 'matiere_id'];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matier::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
