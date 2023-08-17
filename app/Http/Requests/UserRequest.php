<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $method = Str::lower($this->method());

        if ($method === 'post') {
            return [
                'name' => 'bail|required|min:4|max:255',
                'email' => 'bail|required|email|unique:users,email,' . $this->id,
                'password' => [
                    'bail',
                    'required',
                    'confirmed',
                    // Instead of chain link i seperated it to display 1 error at a time
                    // @TODO - check if there is a way to use bail when chain is used.
                    Password::min(8),
                    Password::min(8)->mixedCase(),
                    Password::min(8)->numbers(),
                    Password::min(8)->symbols()
                ],
            ];
        }
    }
}
