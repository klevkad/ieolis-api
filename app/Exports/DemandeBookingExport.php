<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithProperties;

class DemandeBookingExport implements WithProperties, FromView
{
    private $data;

    public function __construct(Array $data) 
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('documents.export.demande-booking', [
            'data' => $this->data
        ]);
    }

    public function properties(): array
    {
        return [
            'creator'        => 'iEOLIS API',
            'lastModifiedBy' => now(),
            'title'          => $this->data['dmd']->no_booking,
            'description'    => 'Demande de booking EOLIS',
            'subject'        => 'Booking',
            'manager'        => 'JeY',
            'company'        => 'EOLIS SA',
        ];
    }

}
