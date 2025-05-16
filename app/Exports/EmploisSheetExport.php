<?php
namespace App\Exports;

use App\Models\EmploiDuTemps;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class EmploisSheetExport implements FromArray, WithHeadings,WithTitle
{
    public function array(): array
    {
        return EmploiDuTemps::with(['classe', 'cours', 'enseignement', 'salle'])->get()->map(function ($e) {
            return [
                'date'        => $e->date,
                'heure_debut' => $e->heure_debut,
                'heure_fin'   => $e->heure_fin,
                'classe'      => optional($e->classe)->nom ?? 'Non défini',
                 
                'cours' => optional(optional($e->cours)->matiere)->nom ?? 'Non défini',
                'enseignement'  => $e->enseignement ? $e->enseignement->nom . ' ' . $e->enseignement->prenom : 'Non défini',
                'salle'       => optional($e->salle)->nom ?? 'Non défini',
            ];
        })->toArray();
    }
    public function title(): string
    {
        return 'Emploi du temps';
    }


    public function headings(): array
    {
        return [
            'Date',
            'Heure Début',
            'Heure Fin',
            'Classe',
            'Cours',
            'Enseignant',
            'Salle',
        ];
    }
}
