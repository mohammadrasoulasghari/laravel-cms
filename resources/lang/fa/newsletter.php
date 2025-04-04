<?php

return [
    'resource' => [
        'label' => 'خبرنامه',
        'plural_label' => 'خبرنامه‌ها',
    ],
    'fields' => [
        'email' => 'ایمیل',
        'subscribed' => 'مشترک شده',
        'created_at' => 'تاریخ ایجاد',
        'updated_at' => 'تاریخ بروزرسانی',
    ],
    'validation' => [
        'email' => [
            'unique' => 'این ایمیل قبلاً ثبت شده است',
        ],
    ],
];
