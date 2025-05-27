<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $kodeOtp;

    public function __construct($kodeOtp)
    {
        $this->kodeOtp = $kodeOtp;
    }

    public function build()
    {
        return $this->subject('Kode OTP Alumni Anda')
            ->view('mail.otpAlumni') // gunakan titik, bukan backslash
            ->with(['kodeOtp' => $this->kodeOtp]);
    }
}
