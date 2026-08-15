<?php

namespace App\Mail;

use App\Models\DoctorToken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentRescheduledMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $originalDoctorName;
    public $originalDate;
    public $originalTime;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(DoctorToken $booking, $originalDoctorName = null, $originalDate = null, $originalTime = null)
    {
        $this->booking = $booking;
        $this->originalDoctorName = $originalDoctorName;
        $this->originalDate = $originalDate;
        $this->originalTime = $originalTime;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Appointment Rescheduled Request - Ayurveda')
                    ->view('emails.appointment_rescheduled');
    }
}
