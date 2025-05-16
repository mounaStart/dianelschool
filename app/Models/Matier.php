<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matier extends Model
{
    use HasFactory;

    protected $fillable = ['nom','coefficient
    '];
    public function cours()
{
    return $this->hasMany(Cours::class);
}

public function evaluations()
{
    return $this->hasMany(Evaluation::class);
}

}
