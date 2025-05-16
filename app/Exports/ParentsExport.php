<?php
 namespace App\Exports;

 use App\Models\ParentEleve;
 use Maatwebsite\Excel\Concerns\FromArray;
 use Maatwebsite\Excel\Concerns\WithHeadings;
 use Maatwebsite\Excel\Concerns\WithTitle;
 
 class ParentsExport implements FromArray, WithHeadings, WithTitle
 {
     public function array(): array
     {
        return ParentEleve::with('eleves')->get()->flatMap(function ($parent) {
            return $parent->eleves->map(function ($eleve) use ($parent) {
                return [
                    'Nom parent'    => $parent->nom,
                    'Prénom parent' => $parent->prenom,
                    'Téléphone'     => $parent->telephone,
                    'Élève'         => $eleve->nom . ' ' . $eleve->prenom,
                ];
            });
        })->toArray();
     }
 
     public function headings(): array
     {
         return [
             'Nom parent',
             'Prénom parent',
             'Téléphone',
             'Élève',
         ];
     }
 
     public function title(): string
     {
         return 'Parents des élèves';
     }
 }
 