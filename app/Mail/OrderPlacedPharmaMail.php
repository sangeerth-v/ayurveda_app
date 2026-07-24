<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\PharmaCompany;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedPharmaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $pharma;
    public $items;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, PharmaCompany $pharma, $items)
    {
        $this->order = $order;
        $this->pharma = $pharma;
        $this->items = $items;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Order Received #' . $this->order->id . ' - Ayurveda')
                    ->view('emails.order_placed_pharma');
    }
}
