<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Register;

use ACTC\Users\Requests\RegisterStepOneRequest;
use ACTC\Users\States\OnboardingStatus\AddressDetails;
use ACTC\Users\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;

class Step01Save
{
    public function __invoke(RegisterStepOneRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create($validated);

        $user->onboarding_status->transitionTo(AddressDetails::class);
        $user->save();

        $user->createAsStripeCustomer();

        event(new Registered($user));

        auth()->guard('web')->login($user);

        return redirect()->route('register.step-two');
    }
}
