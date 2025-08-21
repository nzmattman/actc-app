<?php

declare(strict_types=1);

namespace App\Filament\Resources\Clubs\Pages;

use ACTC\Core\Traits\HasAddress;
use App\Filament\Resources\Clubs\ClubsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditClubs extends EditRecord
{
    use HasAddress;

    protected static string $resource = ClubsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->fillAddressUpdate($data);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $this->fillAddress($data);
    }
}
