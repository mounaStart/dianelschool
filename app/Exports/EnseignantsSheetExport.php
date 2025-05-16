<?php

namespace App\Exports;

use App\Models\Enseignement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EnseignantsSheetExport implements FromCollection, WithTitle, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    protected $columnsToExclude = ['created_at', 'updated_at','photo'];

    public function collection()
    {
        return Enseignement::all()->map(function ($absence) {
            return collect($absence->getAttributes())
                ->except($this->columnsToExclude);
        });
    }

    
    public function title(): string
    {
        return 'Enseignements';
    }

     

    public function headings(): array
    {
        $first = Enseignement::first();
        if ($first) {
            return collect($first->getAttributes())
                ->except($this->columnsToExclude)
                ->keys()
                ->toArray();
        }

        return [];
    }
}
