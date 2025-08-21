<?php

declare(strict_types=1);

namespace App\Filament\Resources\Clubs\Pages;

use ACTC\Core\Address;
use ACTC\Core\Traits\HasAddress;
use App\Filament\Resources\Clubs\ClubsResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewClubs extends ViewRecord
{
    use HasAddress;

    protected static string $resource = ClubsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $this->fillAddress($data);
    }
}
