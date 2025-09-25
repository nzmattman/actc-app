<?php

declare(strict_types=1);

namespace App\Filament\Resources\VideoTags;

use App\Filament\Resources\VideoTags\Pages\EditVideoTag;
use App\Filament\Resources\VideoTags\Pages\ListVideoTags;
use App\Filament\Resources\VideoTags\Schemas\VideoTagForm;
use App\Filament\Resources\VideoTags\Schemas\VideoTagInfolist;
use App\Filament\Resources\VideoTags\Tables\VideoTagsTable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Spatie\Tags\Tag;

class VideoTagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static null|\BackedEnum|string $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $recordTitleAttribute = 'Video Tags';
    protected static null|string|\UnitEnum $navigationGroup = 'Videos';
    protected static ?int $navigationSort = 2; // Add this line

    protected static ?string $navigationLabel = 'Video Tags';
    protected static ?string $modelLabel = 'Video Tag';
    protected static ?string $pluralModelLabel = 'Video Tags';

    public static function form(Schema $schema): Schema
    {
        return VideoTagForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VideoTagInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VideoTagsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVideoTags::route('/'),
            'edit' => EditVideoTag::route('/{record}/edit'),
        ];
    }
}
