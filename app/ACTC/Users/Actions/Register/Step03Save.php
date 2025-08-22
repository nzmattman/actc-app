<?php

declare(strict_types=1);

namespace ACTC\Users\Actions\Register;

use ACTC\Users\Requests\RegisterStepOneRequest;
use Illuminate\Http\RedirectResponse;

class Step03Save
{
    public function __invoke(RegisterStepOneRequest $request): RedirectResponse
    {
        return redirect()->route('register.step-three');
    }
}
