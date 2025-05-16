<?php

namespace App\Exports;

use App\Models\Salle;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SalleSheetExport implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
        return Salle::all()->map(function ($s) {
            return [
                'nom'      => $s->nom,
                'capacite' => $s->capacite,
            ];
        })->toArray();
    }

    public function title(): string
    {
        return 'Salles';
    }

    public function headings(): array
    {
        return ['Nom', 'Capacité'];
    }
}
