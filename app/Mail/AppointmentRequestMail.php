<?php

namespace App\Mail;

use App\Models\DoctorToken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(DoctorToken $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Appointment Request - Ayurveda')
                    ->view('emails.appointment_request');
    }
}
