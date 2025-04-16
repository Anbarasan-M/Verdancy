<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        // Assign the order instance to the public $order variable
        $this->order = $order;
    }

    public function build()
    {
        // Ensure orderItems and products are loaded
        $this->order->load('orderItems.product');

        // Pass the order (with items and products) to the Blade view
        return $this->subject('Order Placed Successfully')
                    ->view('emails.order_successful')
                    ->with(['order' => $this->order]);
    }
}

