<?php

namespace App\Exports;

use App\Models\Facture;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class FactureSheetExport implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
        return Facture::with('eleve')->get()->map(function ($f) {
            return [
                'élève'          => optional($f->eleve)->nom . ' ' . optional($f->eleve)->prenom ?? 'Non défini',
                'montant_total'  => $f->montant_total,
                'statut'         => $f->statut,
                'date_emission'  => $f->date_emission,
                'date_echeance'  => $f->date_echeance,
            ];
        })->toArray();
    }

    public function title(): string
    {
        return 'Factures';
    }

    public function headings(): array
    {
        return ['Élève', 'Montant Total', 'Statut', 'Date d\'Émission', 'Date d\'Échéance'];
    }
}

