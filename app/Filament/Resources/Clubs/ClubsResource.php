<?php

declare(strict_types=1);

namespace App\Filament\Resources\Clubs;

use ACTC\Clubs\Club;
use App\Filament\Resources\Clubs\Pages\CreateClubs;
use App\Filament\Resources\Clubs\Pages\EditClubs;
use App\Filament\Resources\Clubs\Pages\ListClubs;
use App\Filament\Resources\Clubs\Pages\ViewClubs;
use App\Filament\Resources\Clubs\Schemas\ClubsForm;
use App\Filament\Resources\Clubs\Schemas\ClubsInfolist;
use App\Filament\Resources\Clubs\Tables\ClubsTable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClubsResource extends Resource
{
    protected static ?string $model = Club::class;

    protected static null|\BackedEnum|string $navigationIcon = Heroicon::OutlinedBuildingStorefront;

    protected static ?string $recordTitleAttribute = 'Clubs';
    protected static null|string|\UnitEnum $navigationGroup = 'Clubs';

    public static function form(Schema $schema): Schema
    {
        return ClubsForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ClubsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClubsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClubs::route('/'),
            'create' => CreateClubs::route('/create'),
            'view' => ViewClubs::route('/{record}'),
            'edit' => EditClubs::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->with(['address'])
        ;
    }
}
