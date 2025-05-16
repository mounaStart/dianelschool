<?php

namespace App\Exports;

use App\Models\Note;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class NoteSheetExport implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
         

        return Note::with(['evaluation', 'eleve'])->get()->map(function ($n) {
            return [
                'évaluation' => optional($n->evaluation)->titre ?? 'Non défini',
                'élève'      => optional($n->eleve)->nom . ' ' . optional($n->eleve)->prenom ?? 'Non défini',
                'note'       => $n->note,
            ];
        })->toArray();
        
    }

    public function title(): string
    {
        return 'Notes';
    }

    public function headings(): array
    {
        return ['Évaluation', 'Élève', 'Note'];
    }
}
