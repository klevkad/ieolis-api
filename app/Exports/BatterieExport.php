<?php

namespace App\Exports;

use App\Exports\Sheets\BatterieSheet;
use App\Models\Old\Parc\Typengin;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithProperties;


class BatterieExport implements WithMultipleSheets, WithProperties
{
    use Exportable;

    protected $groups;

    public function __construct(Collection $batteriesGroups)
    {
        $this->groups = $batteriesGroups;
    }

    public function properties(): array
    {
        return [
            'creator'        => Auth::user()->name,
            'title'          => 'Liste des batteries',
            'keywords'       => 'batterie,export,spreadsheet',
            'category'       => 'Reports',
            'company'        => 'EOLIS SA',
        ];
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->groups as $codetype => $group) {
            $sheets[] = new BatterieSheet(Typengin::find($codetype), $group);
        }

        return $sheets;
    }

}
