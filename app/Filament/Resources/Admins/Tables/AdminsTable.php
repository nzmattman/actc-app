<?php

declare(strict_types=1);

namespace App\Filament\Resources\Admins\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class AdminsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('active')->boolean()->sortable(),
                TextColumn::make('first_name')->sortable()->searchable(),
                TextColumn::make('last_name')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->before(function (DeleteBulkAction $action, Collection $records) {
                            // Check if current user is in the selection
                            if ($records->contains('id', auth()->id())) {
                                Notification::make()
                                    ->title('Cannot delete yourself')
                                    ->body('You cannot include yourself in a bulk delete operation.')
                                    ->danger()
                                    ->send()
                                ;

                                $action->cancel();
                            }
                        }),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                if (auth()->id() > 2) {
                    $query->where('id', '>', 1);
                }
            })
        ;
    }
}
