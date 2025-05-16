<?php

namespace App\Exports;

use App\Models\FraisScolaire;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FraisScolairesExport implements FromArray, WithTitle, WithHeadings
{
    public function array(): array
    {
        return FraisScolaire::with('classe')->get()->map(function ($frais) {
            return [
                'Nom du frais'    => $frais->nom,
                'Montant'         => $frais->montant,
                'Classe'          => optional($frais->classe)->nom ?? 'Non défini',
                'Description'     => $frais->description,
            ];
        })->toArray();
    }

    public function title(): string
    {
        return 'Frais Scolaires';
    }

    public function headings(): array
    {
        return [
            'Nom du frais',
            'Montant',
            'Classe',
            'Description',
        ];
    }
}
