<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Register;

use ACTC\Core\States\Status\Cancelled;
use ACTC\Users\States\OnboardingStatus\AddressDetails;
use ACTC\Users\States\OnboardingStatus\Completed;
use ACTC\Users\States\OnboardingStatus\UserDetails;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class Step03
{
    public function __invoke(): RedirectResponse|Response
    {
        $user = auth()->user();

        $status = $user->onboarding_status;
        if ($status !== Completed::$name) {
            // find the position in the registration
            switch ($status) {
                case UserDetails::$name:
                    return redirect()->route('register.step-one');

                case AddressDetails::$name:
                    return redirect()->route('register.step-two');
            }
        }

        $price = $user->stripe()->prices->retrieve(config('services.stripe.subscription.id'));

        if (! $price) {
            abort(404);
        }

        $config = [
            'intent' => $user->createSetupIntent()->client_secret,
            'value' => $price->unit_amount / 100,
        ];

        if (is_a($user->status, Cancelled::class)) {
            $config['cancelled'] = true;
        }

        return Inertia::render('Auth/Register/Step03', $config);
    }
}
