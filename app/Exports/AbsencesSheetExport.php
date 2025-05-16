<?php
 namespace App\Exports;

 use App\Models\Absence;
 use Maatwebsite\Excel\Concerns\FromArray;
 use Maatwebsite\Excel\Concerns\WithHeadings;
 use Maatwebsite\Excel\Concerns\WithTitle;
 
 class AbsencesSheetExport implements FromArray, WithHeadings, WithTitle
 {
     public function array(): array
     {
         return Absence::with('eleve')->get()->map(function ($a) {
             return [
                 'date'       => $a->date,
                 'eleve'      => $a->eleve ? $a->eleve->nom . ' ' . $a->eleve->prenom : 'Non défini',
                 'type'       => $a->type ?? 'Non défini',
                 'motif'      => $a->motif ?? 'Non précisé',
             ];
         })->toArray();
     }
 
     public function title(): string
     {
         return 'Absences';
     }
 
     public function headings(): array
     {
         return [
             'Date',
             'Élève',
             'Type',
             'Motif',
         ];
     }
 }
 