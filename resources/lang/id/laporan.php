<?php

return [
    'page_title' => 'Laporan Tracer Study & Survei Kepuasan',
    
    'table' => [
        'headers' => [
            'number' => 'No',
            'title' => 'Judul Laporan',
            'action' => 'Aksi'
        ],
        
        'filter' => [
            'start_date' => 'Tanggal Mulai',
            'end_date' => 'Tanggal Akhir',
            'apply' => 'Terapkan'
        ],

        'reports' => [
            'tracer_study' => 'Rekap Hasil Tracer Study Lulusan',
            'satisfaction_survey' => 'Rekap Hasil Survei Kepuasan Pengguna Lulusan',
            'unfilled_tracer' => 'Daftar Lulusan yang Belum Mengisi Tracer Study',
            'unfilled_survey' => 'Daftar Pengguna Lulusan yang Belum Mengisi Survei Kepuasan'
        ],
        
        'download' => 'Unduh'
    ]
];