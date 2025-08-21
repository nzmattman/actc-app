<?php

declare(strict_types=1);

namespace App\Filament\Resources\Clubs\Tables;

use ACTC\Core\State;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ClubsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('active')->boolean()->sortable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('phone')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable(),
                TextColumn::make('address.state.name')->sortable()->searchable(),
            ])
            ->filters([
                SelectFilter::make('state')
                    ->label('State')
                    ->options(State::pluck('name', 'id'))
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['value'],
                                fn ($query, $state) => $query->whereHas('address', function ($q) use ($state) {
                                    $q->where('state_id', $state);
                                })
                            )
                        ;
                    })
                    ->searchable(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
        ;
    }
}
