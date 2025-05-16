<?php

namespace App\Exports;

use App\Models\Cours;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class CoursSheetExport implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
        return Cours::with(['classe', 'matiere', 'enseignement'])->get()->map(function ($cours) {
            return [
                'classe'       => optional($cours->classe)->nom ?? 'Non défini',
                'matiere'      => optional($cours->matiere)->nom ?? 'Non définie',
                'enseignant'   => $cours->enseignement ? $cours->enseignement->nom . ' ' . $cours->enseignement->prenom : 'Non défini',
            ];
        })->toArray();
    }

    public function title(): string
    {
        return 'Cours';
    }

    public function headings(): array
    {
        return [
            'Classe',
            'Matière',
            'Enseignant',
        ];
    }
}
