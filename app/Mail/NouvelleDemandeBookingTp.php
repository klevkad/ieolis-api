<?php

namespace App\Mail;

use App\Models\Export\DemandeBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class NouvelleDemandeBookingTp extends Mailable
{
    use Queueable, SerializesModels;

    public $demandeBooking;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(DemandeBooking $demandeBooking)
    {
        $this->demandeBooking = $demandeBooking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.export.nouvelle-demande-booking-tp')
//                    ->from(['address' => 'arsene.ta@eolis.ci', 'name' => 'iEOLIS'])
                    ->to('landry.ballet@eolis.ci')
                    ->cc(['marcellin.kouame@eolis.ci','francis.allah@eolis.ci','daniel.dah@eolis.ci'])
                    ->subject('EOL-'.$this->demandeBooking->no_booking.' pour '.$this->demandeBooking->client->liboper)
                    ->attach( Storage::disk('public')->path('fichiers/export/'.substr($this->demandeBooking->date_demande,0,4).'/'.substr($this->demandeBooking->date_demande,5,2).'/'.'bookingtp/EOL-'.$this->demandeBooking->no_booking.'.pdf') , [
                        'as' => 'EOL-'.$this->demandeBooking->no_booking.'.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
