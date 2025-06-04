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
    public $alumniName; // Tambah properti untuk nama alumni

    public function __construct($companyOtp, $alumniName = null)
    {
        $this->companyOtp = $companyOtp;
        $this->alumniName = $alumniName;
    }

    public function build()
    {
        return $this->subject('Kode OTP untuk Perusahaan Anda')
            ->view('mail.otpPerusahaan')
            ->with([
                'companyOtp' => $this->companyOtp,
                'alumniName' => $this->alumniName // Kirim ke view
            ]);
    }
}

