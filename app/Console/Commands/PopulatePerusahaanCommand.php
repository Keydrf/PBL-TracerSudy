<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\PerusahaanController; // Import PerusahaanController

class PopulatePerusahaanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'perusahaan:populate'; // Nama command yang akan dipanggil

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate the perusahaan table from survei_alumni data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controller = new PerusahaanController();
        $controller->populate(); // Panggil fungsi populate() dari PerusahaanController

        $this->info('Perusahaan table populated successfully!');
        return 0;
    }
}
