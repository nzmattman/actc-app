<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Register;

use ACTC\Core\States\Status\Active;
use ACTC\Core\States\Status\Cancelled;
use ACTC\Discounts\Discount;
use ACTC\Discounts\DiscountUser;
use ACTC\Users\Notifications\AccountReactivated;
use ACTC\Users\Requests\StoreCardRequest;
use ACTC\Users\States\OnboardingStatus\Completed;
use Illuminate\Http\RedirectResponse;

class Step03Save
{
    public function __invoke(StoreCardRequest $request): RedirectResponse
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

                if (1 === $discount->type && $discount->weeks) {
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

        $isRenewal = false;
        if (is_a($user->status, Cancelled::class)) {
            $user->notify(new AccountReactivated());
            $isRenewal = true;
        }

        // save the user
        $user->onboarding_status->transitionTo(Completed::class);
        $user->status->transitionTo(Active::class);

        if (!$isRenewal) {
            $user->sendEmailVerificationNotification();
        }

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

        if (2 === $discount->type) {
            $data['currency'] = 'aud';
            $data['amount_off'] = $discount->value;
        }

        if (3 === $discount->type) {
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
