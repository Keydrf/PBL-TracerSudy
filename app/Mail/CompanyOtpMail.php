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

    public $companyOtp; // Properti publik untuk menyimpan kode OTP

    /**
     * Buat instance pesan baru.
     */
    public function __construct($companyOtp)
    {
        $this->companyOtp = $companyOtp;
    }

    /**
     * Dapatkan amplop pesan.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kode OTP untuk Perusahaan Anda', // Subjek email
        );
    }

    /**
     * Dapatkan definisi konten pesan.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.otpPerusahaan', // Nama view Blade untuk email
            with: [
                'companyOtp' => $this->companyOtp, // Data yang akan diteruskan ke view
            ],
        );
    }

    /**
     * Dapatkan lampiran untuk pesan.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
