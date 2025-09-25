<?php

declare(strict_types=1);

namespace App\Filament\Resources\Admins;

use ACTC\Admin\Admin;
use App\Filament\Resources\Admins\Pages\CreateAdmin;
use App\Filament\Resources\Admins\Pages\EditAdmin;
use App\Filament\Resources\Admins\Pages\ListAdmins;
use App\Filament\Resources\Admins\Schemas\AdminForm;
use App\Filament\Resources\Admins\Tables\AdminsTable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static null|\BackedEnum|string $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $recordTitleAttribute = 'Admins';

    protected static null|string|\UnitEnum $navigationGroup = 'Users';

    public static function form(Schema $schema): Schema
    {
        return AdminForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdminsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdmins::route('/'),
            'create' => CreateAdmin::route('/create'),
            'edit' => EditAdmin::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
        ;
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // If authenticated user's ID is greater than 1, hide the first record
        if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->id > 1) {
            $query->where('id', '!=', 1);
        }

        return $query;
    }
}
