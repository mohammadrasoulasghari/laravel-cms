<?php

return [
    'resource' => [
        'label' => 'تنظیمات',
        'plural_label' => 'تنظیمات',
    ],
    'fields' => [
        'title' => 'عنوان',
        'organization_name' => 'نام سازمان',
        'description' => 'توضیحات',
        'logo' => 'لوگو',
        'favicon' => 'فاوآیکون',
        'google_console_code' => 'کد گوگل کنسول',
        'google_analytic_code' => 'کد گوگل آنالیتیک',
        'google_adsense_code' => 'کد گوگل ادسنس',
        'quick_links' => 'لینک‌های سریع',
        'links' => 'لینک‌ها',
        'label' => 'عنوان',
        'url' => 'آدرس',
        'created_at' => 'تاریخ ایجاد',
        'updated_at' => 'تاریخ بروزرسانی',
    ],
    'sections' => [
        'general' => 'عمومی',
        'seo' => [
            'title' => 'سئو',
            'description' => 'کدهای گوگل آنالیتیک و ادسنس را اینجا قرار دهید. این کدها فقط در صفحات مقالات اضافه خواهند شد.',
        ],
        'quick_links' => [
            'title' => 'لینک‌های سریع',
            'description' => 'لینک‌های سریع خود را اینجا اضافه کنید. این لینک‌ها در فوتر وبلاگ نمایش داده خواهند شد.',
        ],
    ],
    'hints' => [
        'logo' => 'حداکثر ارتفاع 400 پیکسل',
        'url' => 'آدرس باید با http:// یا https:// شروع شود',
    ],
];
