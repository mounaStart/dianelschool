<?php

namespace App\Exports;

use App\Models\Classe;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings; 
class ClassesSheetExport implements FromCollection, WithTitle, WithHeadings
{
  
    protected $columnsToExclude = ['created_at', 'updated_at'];

    public function collection()
    {
        return Classe::all()->map(function ($absence) {
            return collect($absence->getAttributes())
                ->except($this->columnsToExclude);
        });
    }

    public function title(): string
    {
        return 'Classes';
    }

    public function headings(): array
    {
        $first = Classe::first();
        if ($first) {
            return collect($first->getAttributes())
                ->except($this->columnsToExclude)
                ->keys()
                ->toArray();
        }

        return [];
    }

}
