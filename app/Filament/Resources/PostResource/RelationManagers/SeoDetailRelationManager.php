<?php

namespace App\Filament\Resources\PostResource\RelationManagers;

use App\Models\SeoDetail;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SeoDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'seoDetail';

    public function form(Form $form): Form
    {
        return $form
            ->schema(SeoDetail::getForm());
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label(trans('seo.fields.title')),
                TextColumn::make('description')
                    ->label(trans('seo.fields.description')),
                TextColumn::make('keywords')->badge()
                    ->label(trans('seo.fields.keywords')),
            ])
            ->filters([
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
