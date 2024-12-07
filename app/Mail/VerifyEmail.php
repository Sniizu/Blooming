<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $verificationLink;
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($user, $verificationLink)
    {
        $this->user = $user;
        $this->verificationLink = $verificationLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.verify_email')
            ->with([
                'user' => $this->user,
                'verificationLink' => $this->verificationLink,
            ]);
    }
}
