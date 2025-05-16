<?php
 
namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AllDataExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ElevesSheetExport(),
            new ParentsExport(),
            new EnseignantsSheetExport(),
            new ClassesSheetExport(),
            new CoursSheetExport(),
            new EvaluationSheetExport(),
            new NoteSheetExport(),
            new SalleSheetExport(),
            new PaiementSheetExport(),
            new FactureSheetExport(),
            new EmploisSheetExport(),
            new AbsencesSheetExport(),
            new FraisScolairesExport()
        ];
    }
}
