<?php

namespace App\Filament\Resources;

use App\Enums\PostStatus;
use App\Filament\Resources\PostResource\Pages\CreatePost;
use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Filament\Resources\PostResource\Pages\ListPosts;
use App\Filament\Resources\PostResource\Pages\ManaePostSeoDetail;
use App\Filament\Resources\PostResource\Pages\ManagePostComments;
use App\Filament\Resources\PostResource\Pages\ViewPost;
use App\Filament\Resources\PostResource\Widgets\BlogPostPublishedChart;
use App\Models\Post;
use App\Tables\Columns\UserPhotoName;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-minus';

    protected static ?string $navigationGroup = 'Blog';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getModelLabel(): string
    {
        return trans('posts.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('posts.label.plural');
    }

    protected static ?int $navigationSort = 3;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function getNavigationBadge(): ?string
    {
        return strval(Post::count());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Post::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(trans('posts.form.title'))
                    ->description(function (Post $record) {
                        return Str::limit($record->sub_title, 40);
                    })
                    ->searchable()->limit(20),
                Tables\Columns\TextColumn::make('status')
                    ->label(trans('posts.form.status'))
                    ->badge()
                    ->color(function ($state) {
                        return $state->getColor();
                    }),
                Tables\Columns\ImageColumn::make('cover_photo_path')
                    ->label(trans('posts.table.cover_photo')),

                UserPhotoName::make('user')
                    ->label(trans('posts.table.author'))
                    ->label('Author'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(trans('posts.table.author'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('user')
                    ->relationship('user', cms_config('user.columns.name'))
                    ->searchable()
                    ->preload()
                    ->multiple(),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    ViewAction::make(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Post')
                ->label(trans('posts.sections.post'))
                ->schema([
                    Fieldset::make('General')
                        ->schema([
                            TextEntry::make('title')
                                ->label(trans('posts.form.title')),
                            TextEntry::make('slug')
                                ->label(trans('posts.form.slug')),
                            TextEntry::make('sub_title')
                                ->label(trans('posts.form.sub_title')),
                        ]),
                    Fieldset::make('Publish Information')
                        ->label(trans('posts.sections.publish_information'))
                        ->schema([
                            TextEntry::make('status')
                                ->label(trans('posts.form.status'))
                                ->badge()->color(function ($state) {
                                    return $state->getColor();
                                }),
                            TextEntry::make('published_at')
                                ->label(trans('posts.sections.scheduled_time'))
                                ->visible(function (Post $record) {
                                    return $record->status === PostStatus::PUBLISHED;
                                }),

                            TextEntry::make('scheduled_for')
                                ->label(trans('posts.sections.scheduled_for'))
                                ->visible(function (Post $record) {
                                    return $record->status === PostStatus::SCHEDULED;
                                }),
                        ]),
                    Fieldset::make('Description')
                        ->schema([
                            TextEntry::make('body')
                                ->html()
                                ->columnSpanFull(),
                        ]),
                ]),
        ]);
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            ViewPost::class,
            ManaePostSeoDetail::class,
            ManagePostComments::class,
            EditPost::class,
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //            \Firefly\FilamentBlog\Resources\PostResource\RelationManagers\SeoDetailRelationManager::class,
            //            \Firefly\FilamentBlog\Resources\PostResource\RelationManagers\CommentsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            BlogPostPublishedChart::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'     => ListPosts::route('/'),
            'create'    => CreatePost::route('/create'),
            'edit'      => EditPost::route('/{record}/edit'),
            'view'      => ViewPost::route('/{record}'),
            'comments'  => ManagePostComments::route('/{record}/comments'),
            'seoDetail' => ManaePostSeoDetail::route('/{record}/seo-details'),
        ];
    }
}
