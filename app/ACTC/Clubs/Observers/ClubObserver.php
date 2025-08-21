<?php

declare(strict_types=1);

namespace ACTC\Clubs\Observers;

use ACTC\Clubs\Club;
use ACTC\Core\Services\GoogleGeocoder;

class ClubObserver
{
    public function saving(Club $club): void
    {
        // fetch latitude and longitude from google address lookup
        $latLng = (new GoogleGeocoder())->getCoordinates($club->address->full_address);

        if (isset($latLng['lat'])) {
            $club->latitude = $latLng['lat'];
            $club->longitude = $latLng['lng'];
        }
    }
}
