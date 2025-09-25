<?php

declare(strict_types=1);

namespace App\Filament\Resources\Videos\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columnSpanFull()
                    ->schema([
                        Section::make('Details')
                            ->schema([
                                TextInput::make('name')->required(),
                                TextInput::make('share_link')->required(),
                                RichEditor::make('description')
                                    ->columnSpanFull()
                                    ->extraAttributes(['style' => 'min-height: 350px;']),
                            ]),
                        Section::make('Settings')
                            ->schema([
                                Toggle::make('active')->default(true),
                                Toggle::make('featured')->default(false),
                                SpatieTagsInput::make('tags')
                                    ->type('videos'),
                                FileUpload::make('thumbnail')->required(),
                            ]),
                        Section::make('Premium Details')
                            ->description('Set a price to make this video available only after purchase.')
                            ->schema([
                                TextInput::make('price')
                                    ->numeric()
                                    ->inputMode('decimal')
                                    ->columnSpan(1),
                            ])
                            ->columns()
                            ->columnSpan(2),
                    ]),
            ])
        ;
    }
}
