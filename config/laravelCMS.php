<?php

use App\Models\User;

return [
    'tables' => [
        'prefix' => 'laravelcms_',
    ],
    'route' => [
        'prefix'     => 'blogs',
        'middleware' => ['web'],
        //        'home' => [
        //            'name' => 'filamentblog.home',
        //            'url' => env('APP_URL'),
        //        ],
        'login' => [
            'name' => 'filamentblog.post.login',
        ],
    ],
    'user' => [
        'model'       => User::class,
        'foreign_key' => 'user_id',
        'columns'     => [
            'name'   => 'name',
            'avatar' => 'profile_photo_path',
        ],
    ],
    'seo' => [
        'meta' => [
            'title'       => 'Filament Blog',
            'description' => 'This is filament blog seo meta description',
            'keywords'    => [],
        ],
    ],

    'recaptcha' => [
        'enabled'    => false, // true or false
        'site_key'   => env('RECAPTCHA_SITE_KEY'),
        'secret_key' => env('RECAPTCHA_SECRET_KEY'),
    ],
];
