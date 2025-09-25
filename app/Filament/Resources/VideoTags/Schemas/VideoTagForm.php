<?php

declare(strict_types=1);

namespace App\Filament\Resources\VideoTags\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VideoTagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->dehydrateStateUsing(fn ($state) => ['en' => $state])
                    ->formatStateUsing(fn ($state) => is_array($state) ? ($state['en'] ?? '') : $state)
                    ->required(),
                RichEditor::make('description')
                    ->extraAttributes(['style' => 'min-height: 350px;'])
                    ->columnSpanFull(),
            ])
        ;
    }
}
