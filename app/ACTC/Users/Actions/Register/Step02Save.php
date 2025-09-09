<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Register;

use ACTC\Core\Address;
use ACTC\Users\Requests\RegisterStepTwoRequest;
use ACTC\Users\States\OnboardingStatus\PaymentDetails;
use Illuminate\Http\RedirectResponse;

class Step02Save
{
    public function __invoke(RegisterStepTwoRequest $request): RedirectResponse
    {
        $user = $request->user();

        $address = Address::updateOrCreate(
            [
                'id' => $user->address_id ?? null,
            ],
            $request->validated()
        );

        $user->address_id = $address->id;
        $user->onboarding_status->transitionTo(PaymentDetails::class);
        $user->save();

        return redirect()->route('register.step-three');
    }
}
