<?php

return [
    'validation' => [
        'required' => 'The :attribute field is required.',
        'min' => [
            'string' => 'The :attribute must be at least :min characters.',
        ],
        'email' => 'The :attribute must be a valid email address.',
        'mimes' => 'The :attribute must be a file of type: :values.',
    ],

    'site' => [
        'full_name' => 'Full Name',
        'email' => 'Email',
        'contact_number' => 'Contact Number',
        'upload_resume' => 'Upload Resume',
    ],
];
