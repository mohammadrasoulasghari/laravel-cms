<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeoDetailResource\Pages\CreateSeoDetail;
use App\Filament\Resources\SeoDetailResource\Pages\EditSeoDetail;
use App\Filament\Resources\SeoDetailResource\Pages\ListSeoDetails;
use App\Models\SeoDetail;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SeoDetailResource extends Resource
{
    protected static ?string $model = SeoDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-magnifying-glass';

    protected static ?string $navigationGroup = 'Blog';

    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return trans('seo.resource.label');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('seo.resource.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(SeoDetail::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                TextColumn::make('post.title')
                    ->label(trans('seo.fields.post'))
                    ->limit(20),
                TextColumn::make('title')
                    ->label(trans('seo.fields.title'))
                    ->limit(20)
                    ->searchable(),
                TextColumn::make('keywords')
                    ->label(trans('seo.fields.keywords'))
                    ->badge()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(trans('seo.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(trans('seo.fields.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSeoDetails::route('/'),
            'create' => CreateSeoDetail::route('/create'),
            'edit' => EditSeoDetail::route('/{record}/edit'),
        ];
    }
}
