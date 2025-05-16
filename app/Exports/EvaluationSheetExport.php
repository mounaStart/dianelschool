<?php
 namespace App\Exports;

 use App\Models\Evaluation;
 use Maatwebsite\Excel\Concerns\FromArray;
 use Maatwebsite\Excel\Concerns\WithHeadings;
 use Maatwebsite\Excel\Concerns\WithTitle;
 
 class EvaluationSheetExport implements FromArray, WithHeadings, WithTitle
 {
     public function array(): array
     {
         return Evaluation::with(['classe', 'matiere'])->get()->map(function ($e) {
             return [
                 'titre'   => $e->titre,
                 'date'    => $e->date,
                 'classe'  => optional($e->classe)->nom ?? 'Non défini',
                 'matiere' => optional($e->matiere)->nom ?? 'Non défini',
             ];
         })->toArray();
     }
 
     public function title(): string
     {
         return 'Évaluations';
     }
 
     public function headings(): array
     {
         return ['Titre', 'Date', 'Classe', 'Matière'];
     }
 }
 