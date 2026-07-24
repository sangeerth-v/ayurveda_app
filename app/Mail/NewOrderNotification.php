<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\PharmaCompany;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewOrderNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $company;
    public $items;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @param PharmaCompany $company
     * @param array $items
     */
    public function __construct(Order $order, PharmaCompany $company, array $items)
    {
        $this->order = $order;
        $this->company = $company;
        $this->items = $items;
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: '🌿 New Order Placed for Your Products',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.new-order-notification',
        );
    }
}
