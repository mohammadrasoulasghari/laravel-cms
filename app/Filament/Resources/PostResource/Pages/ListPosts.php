<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Filament\Resources\PostResource\Widgets\BlogPostPublishedChart;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BlogPostPublishedChart::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All')
                ->label(trans('posts.stats.all')),
            'published' => Tab::make('Published')
                ->label(trans('posts.stats.published'))
                ->modifyQueryUsing(function ($query) {
                    $query->published();
                })->icon('heroicon-o-check-badge'),
            'pending' => Tab::make('Pending')
                ->label(trans('posts.stats.pending'))
                ->modifyQueryUsing(function ($query) {
                    $query->pending();
                })
                ->icon('heroicon-o-clock'),
            'scheduled' => Tab::make('Scheduled')
                ->label(trans('posts.stats.scheduledZ'))
                ->modifyQueryUsing(function ($query) {
                    $query->scheduled();
                })
                ->icon('heroicon-o-calendar-days'),
        ];
    }
}
