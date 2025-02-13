<?php

return [
    'resource' => [
        'plural_label' => 'دسته‌بندی‌ها',
        'label' => 'دسته‌بندی',
        'navigation_group' => 'وبلاگ',
        'section_title' => 'دسته‌بندی',
    ],
    'fields' => [
        'name' => 'نام',
        'slug' => 'اسلاگ',
        'posts_count' => 'تعداد پست‌ها',
        'created_at' => 'تاریخ ایجاد',
        'updated_at' => 'تاریخ بروزرسانی',
    ],
    'relation' => [
        'posts' => [
            'label' => 'مقالات',
            'title' => 'عنوان',
            'subtitle' => 'زیرعنوان',
            'status' => 'وضعیت'
        ]
    ]
];
