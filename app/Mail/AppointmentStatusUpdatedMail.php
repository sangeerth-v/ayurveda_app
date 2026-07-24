<?php

namespace App\Mail;

use App\Models\DoctorToken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentStatusUpdatedMail extends Mailable
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
        $statusText = $this->booking->status;
        if ($statusText === 'Booked') {
            $statusText = 'Accepted/Scheduled';
        }
        return $this->subject('Appointment Status Update: ' . $statusText . ' - Ayurveda')
                    ->view('emails.appointment_status_updated');
    }
}
