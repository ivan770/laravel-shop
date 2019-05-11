<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class CreateEditAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'region' => ['required', 'max:255'],
            'city' => ['required', 'max:255'],
            'street' => ['required', 'max:255'],
            'building' => ['required', 'numeric', 'max:10000'],
            'apartment' => ['numeric', 'max:10000'],
        ];
    }
}
