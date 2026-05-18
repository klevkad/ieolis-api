<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NouvelUtilisateurTier extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $clearPassword;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, string $clearPassword)
    {
        $this->user = $user;
        $this->clearPassword = $clearPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.nouveau-compte-utilisateur', ['user' => $this->user, 'clearPassword' => $this->clearPassword])
//                    ->from(['address' => 'arsene.ta@eolis.ci', 'name' => 'iEOLIS'])
                    ->to($this->user->email)
//                    ->cc(['marcellin.kouame@eolis.ci','francis.allah@eolis.ci'])
                    ->subject('Accès à iEOLIS');
    }
}
