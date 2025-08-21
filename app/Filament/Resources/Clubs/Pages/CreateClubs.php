<?php

declare(strict_types=1);

namespace App\Filament\Resources\Clubs\Pages;

use ACTC\Core\Traits\HasAddress;
use App\Filament\Resources\Clubs\ClubsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateClubs extends CreateRecord
{
    use HasAddress;

    protected static string $resource = ClubsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->fillAddressCreate($data);
    }
}
