<?php

return [
    'page_title' => 'Company Data',
    'add_button' => 'Update',
    'table' => [
        'headers' => [
            'number' => 'No',
            'company_code' => 'Company Code',
            'supervisor_name' => 'Supervisor Name',
            'agency_type' => 'Agency Type',
            'agency_name' => 'Agency Name',
            'phone' => 'Phone',
            'email' => 'Email',
            'alumni_name' => 'Alumni Name',
            'program_study' => 'Study Program',
            'graduation_year' => 'Graduation Year',
            'action' => 'Action'
        ],
    ],
    'datatable' => [
        'processing' => 'Processing...',
        'search' => 'Search:',
        'length_menu' => 'Show _MENU_ entries',
        'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
        'info_empty' => 'Showing 0 to 0 of 0 entries',
        'info_filtered' => '(filtered from _MAX_ total entries)',
        'loading_records' => 'Loading...',
        'zero_records' => 'No matching records found',
        'paginate' => [
            'first' => 'First',
            'last' => 'Last',
            'next' => 'Next',
            'previous' => 'Previous'
        ]
    ]
];