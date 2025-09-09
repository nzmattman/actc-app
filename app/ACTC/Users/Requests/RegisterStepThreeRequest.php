<?php

declare(strict_types=1);

namespace ACTC\Users\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterStepThreeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array|Rule|string>
     */
    public function rules(): array
    {
        return [
            'paymentMethodId' => ['required', 'string'],
        ];
    }
}
