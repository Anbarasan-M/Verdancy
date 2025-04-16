<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationSuccessfulMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // User object passed to the mail

    /**
     * Create a new message instance.
     *
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Registration Successful')
                    ->view('emails.registration_successful')
                    ->with([
                        'userName' => $this->user->name,
                    ]);
    }
}
