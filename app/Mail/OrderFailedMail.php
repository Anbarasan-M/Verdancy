<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderFailedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $errorMessage;

    public function __construct($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    public function build()
    {
        return $this->subject('Order Failed')
                    ->view('emails.order_failed')
                    ->with(['errorMessage' => $this->errorMessage]);
    }
}
