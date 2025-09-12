<?php

namespace ACTC\Orders\Actions\Subscriptions;

use ACTC\Core\States\Status\Cancelled;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class Cancel
{
    public function __invoke(Request $request): RedirectResponse
    {
        $user = $request->user();
        $subscription = $user->subscription('main');

        if ($subscription && $subscription->active()) {
            $subscription->cancelNow();
        }

        $user->status->transitionTo(Cancelled::class);

        return redirect()->route('dashboard');
    }
}
