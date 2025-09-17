<?php

declare(strict_types=1);

namespace ACTC\Core\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array|Rule|string>
     */
    public function rules(): array
    {
        return [
            'street_address' => ['required', 'string'],
            'street_address_2' => ['nullable'],
            'suburb' => ['nullable'],
            'city' => ['nullable'],
            'state_id' => ['required', 'integer', 'exists:states,id'],
            'postcode' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'state_id.required' => 'State is required.',
            'state_id.integer' => 'State is required.',
            'state_id.exists' => 'State does not exist.',
        ];
    }
}
