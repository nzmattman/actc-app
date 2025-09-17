<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Address;

use ACTC\Core\Data\AddressData;
use ACTC\Core\Requests\AddressRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class AddressUpdate
{
    public function __invoke(AddressRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->updateAddress(AddressData::fromArray($request->validated()));

        return Redirect::route('profile.address.edit')->with('status', 'Your address has been updated.');
    }
}
