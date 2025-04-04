<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages\CreateComment;
use App\Filament\Resources\CommentResource\Pages\EditComment;
use App\Filament\Resources\CommentResource\Pages\ListComments;
use App\Models\Comment;
use App\Tables\Columns\UserPhotoName;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;


class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Blog';

    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return trans('comment.resource.label');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('comment.resource.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Comment::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                UserPhotoName::make('user')
                    ->label(trans('comment.fields.user')),
                TextColumn::make('post.title')
                    ->label(trans('comment.fields.post'))
                    ->numeric()
                    ->limit(20)
                    ->sortable(),
                TextColumn::make('comment')
                    ->label(trans('comment.fields.comment'))
                    ->searchable()
                    ->limit(20),
                ToggleColumn::make('approved')
                    ->label(trans('comment.fields.approved'))
                    ->beforeStateUpdated(function ($record, $state) {
                        if ($state) {
                            $record->approved_at = now();
                        } else {
                            $record->approved_at = null;
                        }

                        return $state;
                    }),
                TextColumn::make('approved_at')
                    ->label(trans('comment.fields.approved_at'))
                    ->sortable()
                    ->placeholder('Not approved yet'),

                TextColumn::make('created_at')
                    ->label(trans('comment.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(trans('comment.fields.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user')
                    ->label(trans('comment.filters.user'))
                    ->relationship('user', cms_config('user.columns.name'))
                    ->searchable()
                    ->preload()
                    ->multiple(),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ViewAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListComments::route('/'),
            'create' => CreateComment::route('/create'),
            'edit'   => EditComment::route('/{record}/edit'),
        ];
    }
}
