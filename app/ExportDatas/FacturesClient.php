<?php
namespace App\ExportDatas;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FacturesClient implements FromCollection, WithHeadings
{
    protected $factures;

    public function __construct($factures)
    {
        $this->factures = $factures;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Transformez la collection de factures pour obtenir les champs souhaités
        return collect($this->factures)->map(function ($item) {
            return [
                'N° Facture'   => $item['no_fact'] ?? '',
                'Date Facture' => $item['date_fact'] ? \Carbon\Carbon::parse($item['date_fact'])->format('Y-m-d') : '',
                'Libellé'      => $item['lib_ent_fac'] ?? '',
                'N° BL'        => $item['bl']['nobl'] ?? '',
                'Nom Client'   => $item['nom_client'] ?? '',
                'Pages'        => $item['pages'] ?? 0,
            ];
        });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'N° Facture',
            'Date Facture',
            'Libellé',
            'N° BL',
            'Nom Client',
            'Pages'
        ];
    }
}
