<?php

namespace App\Exports\Sheets;

use App\Models\Old\Parc\Typengin;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class BatterieSheet implements FromView, WithTitle
{
    private $batteries;
    private $typengin;

    public function __construct(Typengin $typengin, Collection $batteries)
    {
        $this->batteries = $batteries;
        $this->typengin  = $typengin;
    }

    public function view(): View
    {
        return view('documents.export.sheets.parc.batterie', [
            'typengin' => $this->typengin,
            'batteries' => $this->batteries,
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->typengin->libtype;
    }

}
