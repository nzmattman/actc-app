<?php

declare(strict_types=1);

namespace ACTC\Core\Services;

class GoogleGeocoder
{
    public function getCoordinates($address): array|false
    {
        // Encode the address for URL
        $encodedAddress = urlencode($address);
        $apiKey = config('services.google.api_key');

        // Build the API URL
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$encodedAddress}&key={$apiKey}";

        // Make the API request
        $response = file_get_contents($url);

        if (false === $response) {
            return false;
        }

        // Parse the JSON response
        $data = json_decode($response, true);

        // Check if the request was successful
        if ('OK' !== $data['status'] || empty($data['results'])) {
            return false;
        }

        // Extract coordinates from the first result
        $location = $data['results'][0]['geometry']['location'];

        return [
            'lat' => $location['lat'],
            'lng' => $location['lng'],
        ];
    }
}
