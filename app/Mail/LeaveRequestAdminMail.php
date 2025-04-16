<?php

namespace App\Mail;

use App\Models\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveRequestAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $leaveRequest;

    /**
     * Create a new message instance.
     *
     * @param Leave $leaveRequest
     */
    public function __construct(Leave $leaveRequest)
    {
        $this->leaveRequest = $leaveRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Leave Request Created')
                    ->view('emails.leave_request_admin')
                    ->with([
                        'leaveDate' => $this->leaveRequest->leave_date,
                        'leaveReason' => $this->leaveRequest->reason,
                        'serviceProviderName' => $this->leaveRequest->serviceProvider->name, // Use the relationship here
                    ]);
    }
}
