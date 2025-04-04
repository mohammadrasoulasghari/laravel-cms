<?php

namespace App\Models;

use Database\Factories\SettingFactory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'logo',
        'favicon',
        'organization_name',
        'google_console_code',
        'google_analytic_code',
        'google_adsense_code',
        'quick_links',
    ];

    protected $casts = [
        'quick_links' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected function getLogoImageAttribute(): string
    {
        return asset('storage/'.$this->logo);
    }

    protected function getFavIconImageAttribute(): string
    {
        return asset('storage/'.$this->favicon);
    }

    protected static function newFactory(): SettingFactory
    {
        return new SettingFactory;
    }

    public static function getForm(): array
    {
        return [
            Section::make('General Information')
                ->schema([
                    TextInput::make('title')
                        ->label(trans('setting.fields.title'))
                        ->maxLength(155)
                        ->required(),
                    TextInput::make('organization_name')
                        ->label(trans('setting.fields.organization_name'))
                        ->required()
                        ->maxLength(155)
                        ->minLength(3),
                    Textarea::make('description')
                        ->label(trans('setting.fields.description'))
                        ->required()
                        ->minLength(10)
                        ->maxLength(1000)
                        ->columnSpanFull(),
                    FileUpload::make('logo')
                        ->label(trans('setting.fields.logo'))
                        ->hint('Max height 400')
                        ->directory('setting/logo')
                        ->maxSize(1024 * 1024 * 2)
                        ->rules('dimensions:max_height=400')
                        ->nullable()->columnSpanFull(),
                    FileUpload::make('favicon')
                        ->label(trans('setting.fields.favicon'))
                        ->directory('setting/favicon')
                        ->maxSize(50)
                        ->nullable()->columnSpanFull(),
                ])->columns(2),

            Section::make('SEO')
                ->description('Place your google analytic and adsense code here. This will be added to the head tag of your blog post only.')
                ->schema([
                    Textarea::make('google_console_code')
                        ->startsWith('<meta')
                        ->nullable()
                        ->columnSpanFull(),
                    Textarea::make('google_analytic_code')
                        ->startsWith('<script')
                        ->endsWith('</script>')
                        ->nullable()
                        ->columnSpanFull(),
                    Textarea::make('google_adsense_code')
                        ->startsWith('<script')
                        ->endsWith('</script>')
                        ->nullable()
                        ->columnSpanFull(),
                ])->columns(2),
            Section::make('Quick Links')
                ->description('Add your quick links here. This will be displayed in the footer of your blog.')
                ->schema([
                    Repeater::make('quick_links')
                        ->label(trans('setting.fields.links'))
                        ->schema([
                            TextInput::make('label')
                                ->label(trans('setting.fields.label'))
                                ->required()
                                ->maxLength(155),
                            TextInput::make('url')
                                ->label(trans('setting.fields.url'))
                                ->helperText('URL should start with http:// or https://')
                                ->required()
                                ->url()
                                ->maxLength(255),
                        ])->columns(2),
                ])->columnSpanFull(),
        ];
    }

    public function getTable(): string
    {
        return table_name('settings');
    }
}
