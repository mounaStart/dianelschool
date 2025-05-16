<?php

namespace App\Exports;

use App\Models\Paiement;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PaiementSheetExport implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
        return Paiement::with('facture')->get()->map(function ($p) {
            return [
                'facture_id'    => $p->facture_id,
                'montant_paye'  => $p->montant_paye,
                'mode_paiement' => $p->mode_paiement,
                'date_paiement' => $p->date_paiement,
            ];
        })->toArray();
    }

    public function title(): string
    {
        return 'Paiements';
    }

    public function headings(): array
    {
        return ['Facture ID', 'Montant Payé', 'Mode de Paiement', 'Date de Paiement'];
    }
}
