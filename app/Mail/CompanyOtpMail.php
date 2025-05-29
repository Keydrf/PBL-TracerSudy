<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompanyOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $companyOtp;

    public function __construct($companyOtp)
    {
        $this->companyOtp = $companyOtp;
    }

    public function build()
    {
        return $this->subject('Kode OTP untuk Perusahaan Anda') // Samakan subject dengan OtpMail
            ->view('mail.otpPerusahaan')
            ->with(['companyOtp' => $this->companyOtp]);
    }
}

