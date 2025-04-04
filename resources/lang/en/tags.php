<?php

return [
    'resource' => [
        'name'             => 'Tag',
        'navigation_group' => 'Blog',
    ],
    'fields' => [
        'name'       => 'Name',
        'slug'       => 'Slug',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],
    'messages' => [
        'unique_name' => 'The name has already been taken',
        'unique_slug' => 'The slug has already been taken',
    ],
];
