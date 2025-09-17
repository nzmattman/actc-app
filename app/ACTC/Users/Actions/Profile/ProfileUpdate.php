<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Profile;

use ACTC\Users\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ProfileUpdate
{
    public function __invoke(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
            $request->user()->save();
            $request->user()->sendEmailVerificationNotification();
        } else {
            $request->user()->save();
        }

        return Redirect::route('profile.edit')->with('status', 'Your profile has been updated.');
    }
}
