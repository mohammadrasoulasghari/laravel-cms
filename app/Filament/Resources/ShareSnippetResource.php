<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShareSnippetResource\Pages\EditShareSnippet;
use App\Filament\Resources\ShareSnippetResource\Pages\ListShareSnippets;
use App\Models\ShareSnippet;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShareSnippetResource extends Resource
{
    protected static ?string $model = ShareSnippet::class;

    protected static ?string $navigationIcon = 'heroicon-o-share';

    protected static ?string $navigationGroup = 'Blog';

    public static function getModelLabel(): string
    {
        return trans('share-snippet.resource.label');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('share-snippet.resource.plural_label');
    }

    protected static ?int $navigationSort = 7;

    public static function canCreate(): bool
    {
        return !(self::$model::all()->count() > 0);
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(ShareSnippet::getform());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('script_code')
                    ->label(trans('share-snippet.columns.script_code'))
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('html_code')
                    ->label(trans('share-snippet.columns.html_code'))
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('active')
                    ->label(trans('share-snippet.columns.active')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => ListShareSnippets::route('/'),
            'edit'  => EditShareSnippet::route('/{record}/edit'),
        ];
    }
}
