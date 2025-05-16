<?php

namespace App\Exports;

use App\Models\Eleve;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
class ElevesSheetExport implements FromArray, WithHeadings ,WithTitle
{
    public function array(): array
    {
        return Eleve::with('classe')->get()->map(function ($eleve) {
            return [
                'nom'             => $eleve->nom,
                'prenom'          => $eleve->prenom,
                'adresse'         => $eleve->adresse,
                'numero_national' => $eleve->numero_national,
                'sexe'            => $eleve->sexe,
                'nationalite'     => $eleve->nationalite,
                'date_naissance'  => $eleve->date_naissance,
                'lieux_naissance' => $eleve->lieux_naissance,
                'telephone1'      => $eleve->telephone1,
                'telephone2'      => $eleve->telephone2,
                'type_eleve'      => $eleve->type_eleve,
                'moyen_transport' => $eleve->moyen_transport,
                'parent_id'          => $eleve->parent ? $eleve->parent->nom . ' ' . $eleve->parent->prenom : 'Non défini',
 
                'classe'          => optional($eleve->classe)->nom ?? 'Non défini',
                'suspendu'        => $eleve->suspendu == 1 ? 'Non' : 'Oui',
            ];
        })->toArray();
    }
    public function title(): string
    {
        return 'Eleves';
    }

    public function headings(): array
    {
        return [
            'Nom',
            'Prénom',
            'Adresse',
            'Numéro National',
            'Sexe',
            'Nationalité',
            'Date de Naissance',
            'Lieu de Naissance',
            'Téléphone 1',
            'Téléphone 2',
            'Type Élève',
            'Moyen de Transport',
            'Parent d\'eleve',
            
            'Classe',
            'Suspendu',
        ];
    }
}
