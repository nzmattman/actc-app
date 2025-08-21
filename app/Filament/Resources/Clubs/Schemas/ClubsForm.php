<?php

declare(strict_types=1);

namespace App\Filament\Resources\Clubs\Schemas;

use ACTC\Core\Address;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClubsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                self::detailsFields(),
                Address::filamentFields(),
                Section::make('Location Map')
                    ->schema([
                        ViewEntry::make('map')
                            ->view('filament.components.google-map')
                            ->columnSpanFull(),
                    ])
                    ->visible(function ($record) {
                        return $record
                            && ($record->latitude && $record->longitude);
                    })
                    ->hiddenOn(['create', 'edit']),
            ])
            ->columns(1)
        ;
    }

    public static function detailsFields()
    {
        return Section::make('Details')
            ->schema([
                Toggle::make('active')->columnSpan(2)->default(true),
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('email')->maxLength(255)->rules(['email']),
                TextInput::make('phone')->maxLength(255),
                TextInput::make('website')->maxLength(255)->rules(['url']),
            ])
            ->columns()
        ;
    }
}
