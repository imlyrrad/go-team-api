<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class TaskRequest extends FormRequest
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

        if ($method === 'get') {
            return [
                'current_page' => 'bail|numeric|required_with:per_page',
                'per_page' => 'bail|numeric|required_with:current_page',
                'keywords' => 'string|nullable',
            ];
        }

        if ($method === 'put' || $method === 'post') {
            return [
                'title' => 'required|string|max:255',
                'description' => 'required',
                'date_due' => 'required|date',
                'is_completed' => 'required|boolean',
            ];
        }
    }
}
