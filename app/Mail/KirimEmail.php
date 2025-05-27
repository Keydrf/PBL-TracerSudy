<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KirimEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $pesan;

    public function __construct($pesan)
    {
        $this->pesan = $pesan;
    }

    public function build()
    {
        return $this->view('contoh')
                    ->with(['pesan' => $this->pesan]);
    }
}
