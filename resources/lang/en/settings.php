<?php

return [

    'header'     => 'Settings',
    'profile'    => [
        'label'       => 'Your profile',
        'description' => 'Choose a unique username and share public details about yourself.',
        'modal'       => [
            'header'   => 'Edit profile',
            'username' => [
                'label'       => 'Username',
                'placeholder' => 'Choose a username...',
            ],
            'summary'  => [
                'label'       => 'Summary',
                'placeholder' => 'Tell us a little bit about yourself...',
            ],
        ],
    ],
    'digest'     => [
        'label'       => 'Weekly digest',
        'description' => 'Control whether to receive a weekly summary of your published content.',
    ],
    'appearance' => [
        'label'       => 'Dark mode',
        'description' => 'Use a dark appearance for Canvas.',
    ],
    'export'     => [
        'label'       => 'Download your information',
        'description' => 'Download a copy of the information you’ve shared on Canvas to a .zip file.',
    ],

];
