<?php

declare(strict_types=1);

namespace App\Filament\Resources\VideoTags\Pages;

use App\Filament\Resources\VideoTags\VideoTagResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditVideoTag extends EditRecord
{
    protected static string $resource = VideoTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }
}
