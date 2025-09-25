<?php

namespace App\Filament\Resources\VideoTags\Pages;

use App\Filament\Resources\VideoTags\VideoTagResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVideoTags extends ListRecords
{
    protected static string $resource = VideoTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
