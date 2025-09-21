<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Card;

use ACTC\Users\Requests\StoreCardRequest;
use Illuminate\Http\RedirectResponse;

class CardStore
{
    public function __invoke(StoreCardRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $user->addPaymentMethod($request->paymentMethodId);

        return redirect()->route('profile.card');
    }
}
