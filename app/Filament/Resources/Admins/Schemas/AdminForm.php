<?php

declare(strict_types=1);

namespace App\Filament\Resources\Admins\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminForm
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
                                TextInput::make('first_name')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('last_name')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                            ]),
                        Section::make('Settings')
                            ->schema([
                                Toggle::make('status')
                                    ->label('Active')
                                    ->default(true)
                                    ->columnSpan(2)
                                    ->formatStateUsing(fn (?string $state): bool => 'active' === $state)
                                    ->dehydrateStateUsing(fn (bool $state): string => $state ? 'active' : 'cancelled'),
                            ]),
                    ]),
            ])
        ;
    }
}
