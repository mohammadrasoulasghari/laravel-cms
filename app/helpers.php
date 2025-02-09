<?php

if (!function_exists('table_name')) {
    function table_name(string $table): string
    {
        return config('laravelCMS.tables.prefix') . $table;
    }
}
if (!function_exists('cms_config')) {
    function cms_config(?string $key = null)
    {
        if ($key === null) {
            return config('laravelCMS');
        }

        return config("laravelCMS.{$key}");
    }
}
