<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Register;

use ACTC\Core\Resources\StateSelectResource;
use ACTC\Core\State;
use ACTC\Users\States\OnboardingStatus\Completed;
use ACTC\Users\States\OnboardingStatus\PaymentDetails;
use ACTC\Users\States\OnboardingStatus\UserDetails;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class Step02
{
    public function __invoke(): RedirectResponse|Response
    {
        $status = auth()->user()->onboarding_status;
        if ($status !== Completed::$name) {
            // find the position in the registration
            switch ($status) {
                case UserDetails::$name:
                    return redirect()->route('register.step-one');

                case PaymentDetails::$name:
                    return redirect()->route('register.step-three');
            }
        }

        $config = [
            'states' => StateSelectResource::collection(State::all())->resolve(),
        ];

        return Inertia::render('Auth/Register/Step02', $config);
    }
}
