<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Register;

use ACTC\Core\States\Status\Active;
use ACTC\Discounts\Discount;
use ACTC\Discounts\DiscountUser;
use ACTC\Users\Requests\RegisterStepThreeRequest;
use ACTC\Users\States\OnboardingStatus\Completed;
use Illuminate\Http\RedirectResponse;

class Step03Save
{
    public function __invoke(RegisterStepThreeRequest $request) // : RedirectResponse
    {
        $user = auth()->user();
        $user->addPaymentMethod($request->paymentMethodId);
        $user->updateDefaultPaymentMethod($request->paymentMethodId);

        // create the subscription
        $subscription = $user->newSubscription('main', config('services.stripe.subscription.id'));

        if ($request->get('discountId')) {
            $discount = Discount::uuid($request->get('discountId'));
            if ($discount) {
                DiscountUser::create([
                    'user_id' => $user->id,
                    'discount_id' => $discount->id,
                ]);

                if ($discount->type === 1 && $discount->weeks) {
                    $trialDays = $discount->weeks * 7;
                    $subscription->trialDays($trialDays);
                } else {
                    $discountCoupon = $this->findOrCreate($discount, $user);

                    if ($discountCoupon) {
                        $subscription->withCoupon($discountCoupon);
                    }
                }
            }
        }

        $subscription->createAndSendInvoice();

        // save the user
        $user->onboarding_status->transitionTo(Completed::class);
        $user->status->transitionTo(Active::class);
        $user->sendEmailVerificationNotification();

        // redirect to the dashboard
        return redirect()->route('dashboard');
    }

    private function findOrCreate(Discount $discount, $user): string
    {
        $data = [
            'duration' => 'once',
            'name' => $discount->name,
            'id' => $discount->uuid,
        ];

        if ($discount->type === 2) {
            $data['currency'] = 'aud';
            $data['amount_off'] = $discount->value;
        }

        if ($discount->type === 3) {
            $data['percent_off'] = $discount->percent;
        }

        // first check if we have one
        try {
            $coupon = $user->stripe()->coupons->retrieve($discount->uuid);
            if ($coupon) {
                return $coupon->id;
            }
        } catch (\Exception $e) {

        }

        return $user->stripe()->coupons->create($data)->id;
    }
}
