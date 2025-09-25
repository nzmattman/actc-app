<?php

declare(strict_types=1);

namespace App\Filament\Resources\VideoTags\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VideoTagInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('description')->html(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ])
        ;
    }
}
