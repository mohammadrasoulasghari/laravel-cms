<?php

return [
    'resource' => [
        'plural_label' => 'Categories',
        'navigation_group' => 'Blog',
        'section_title' => 'Category',
    ],
    'fields' => [
        'name' => 'Name',
        'slug' => 'Slug',
        'posts_count' => 'Posts Count',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],
    'relation' => [
        'posts' => [
            'label' => 'Posts',
            'title' => 'Title',
            'subtitle' => 'Subtitle',
            'status' => 'Status'
        ]
    ]
];
