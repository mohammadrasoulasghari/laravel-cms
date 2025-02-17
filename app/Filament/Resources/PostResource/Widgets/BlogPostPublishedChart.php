<?php

namespace App\Filament\Resources\PostResource\Widgets;

use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BlogPostPublishedChart extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('منتشر شده', Post::published()->count()),
            Stat::make('در صف انتشار', Post::scheduled()->count()),
            Stat::make('پیش نویس', Post::pending()->count()),
        ];
    }
}
