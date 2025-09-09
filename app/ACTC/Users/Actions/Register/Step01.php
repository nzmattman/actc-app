<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Register;

use ACTC\Users\States\OnboardingStatus\AddressDetails;
use ACTC\Users\States\OnboardingStatus\Completed;
use ACTC\Users\States\OnboardingStatus\PaymentDetails;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class Step01
{
    public function __invoke(): RedirectResponse|Response
    {
        if (auth()->check()) {
            $status = auth()->user()->onboarding_status;
            if ($status !== Completed::$name) {
                // find the position in the registration
                switch ($status) {
                    case AddressDetails::$name:
                        return redirect()->route('register.step-two');

                    case PaymentDetails::$name:
                        return redirect()->route('register.step-three');
                }
            }
        }

        return Inertia::render('Auth/Register/Step01');
    }
}
