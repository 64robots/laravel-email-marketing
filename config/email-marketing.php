<?php

return [
    'tool' => env('EMAIL_MARKETING_DRIVER', 'mailchimp'),
    
    'tools' => [
        'activecampaign' => [
            'api_key' => env('ACTIVECAMPAIGN_API_KEY', ''),
            'url' => env('ACTIVECAMPAIGN_URL', '')
        ],

        'getresponse' => [
            'api_key' => env('GETRESPONSE_API_KEY', '')
        ],
        
        'mailchimp' => [
            'api_key' =>  env('MAILCHIMP_API_KEY', '')
        ]
    ],

];
