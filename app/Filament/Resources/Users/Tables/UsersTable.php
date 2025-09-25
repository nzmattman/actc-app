<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('status')->boolean()->sortable(),
                TextColumn::make('first_name')->sortable()->searchable(),
                TextColumn::make('last_name')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable(),
            ])
            ->filters([
            ])
            ->recordActions([
            ])
            ->toolbarActions([
            ])
        ;
    }
}
