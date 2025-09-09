<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use ACTC\Users\States\OnboardingStatus\AddressDetails;
use ACTC\Users\States\OnboardingStatus\Completed;
use ACTC\Users\States\OnboardingStatus\PaymentDetails;
use ACTC\Users\States\OnboardingStatus\UserDetails;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Onboarded
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(Request): (Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        $status = $request->user()->onboarding_status;
        if ($status !== Completed::$name) {
            // find the position in the registration
            switch ($status) {
                case UserDetails::$name:
                    return redirect()->route('register.step-one');

                case AddressDetails::$name:
                    return redirect()->route('register.step-two');

                case PaymentDetails::$name:
                    return redirect()->route('register.step-three');
            }
        }

        return $next($request);
    }
}
