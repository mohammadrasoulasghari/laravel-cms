<?php

return [
    'resource' => [
        'label' => 'Newsletter',
        'plural_label' => 'Newsletters',
    ],
    'fields' => [
        'email' => 'Email',
        'subscribed' => 'Subscribed',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At'
    ],
    'validation' => [
        'email' => [
            'unique' => 'This email has already been registered',
        ]
    ]
];
