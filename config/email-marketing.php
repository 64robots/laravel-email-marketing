<?php

return [
    'tool' => env('EMAIL_MARKETING_DRIVER', 'mailchimp'),
    
    'tools' => [
        'mailchimp' => [
            'display' => 'MailChimp',
            'driver' => 'mailchimp',
            'api_key' =>  env('MAILCHIMP_API_KEY', '')
        ]
    ],

];
