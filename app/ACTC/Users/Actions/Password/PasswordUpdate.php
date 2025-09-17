<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Password;

use ACTC\Users\Requests\PasswordUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class PasswordUpdate
{
    public function __invoke(PasswordUpdateRequest $request): RedirectResponse
    {
        $request->user()->forceFill([
            'password' => $request->validated('password'),
        ])->save();

        return Redirect::route('profile.password.edit')->with('status', 'Your password has been updated.');
    }
}
