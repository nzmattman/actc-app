<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Address;

use ACTC\Core\Resources\AddressResource;
use ACTC\Core\Resources\StateSelectResource;
use ACTC\Core\State;
use Inertia\Inertia;
use Inertia\Response;

class AddressEdit
{
    public function __invoke(): Response
    {
        $config = [
            'status' => session('status'),
            'states' => StateSelectResource::collection(State::all())->resolve(),
            'address' => (new AddressResource(auth()->user()->address))->resolve(),
        ];

        return Inertia::render('Profile/EditAddress', $config);
    }
}
