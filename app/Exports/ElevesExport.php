<?php

 
namespace App\Exports;

use App\Models\Eleve;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ElevesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // return Eleve::all();
        return Eleve::select('id', 'nom', 'prenom', 'sexe', 'date_naissance', 'classe_id')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nom', 'Prénom', 'Genre', 'Date de naissance', 'Classe ID'];
    }
}
