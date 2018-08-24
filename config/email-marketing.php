<?php

return [
    'tool' => env('EMAIL_MARKETING_DRIVER', 'mailchimp'),
    
    'tools' => [
        'activecampaign' => [
            'display' => 'ActiveCampaign',
            'api_key' => env('ACTIVECAMPAIGN_API_KEY', ''),
            'url' => env('ACTIVECAMPAIGN_URL', '')
        ],

        'getresponse' => [
            'display' => 'GetResponse',
            'api_key' => env('GETRESPONSE_API_KEY', '')
        ],
        
        'mailchimp' => [
            'display' => 'MailChimp',
            'api_key' =>  env('MAILCHIMP_API_KEY', '')
        ]
    ],

];
