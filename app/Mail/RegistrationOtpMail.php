<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($otp, $name)
    {
        $this->otp = $otp;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Registration OTP - Ayurveda App')
                    ->view('emails.registration_otp');
    }
}
