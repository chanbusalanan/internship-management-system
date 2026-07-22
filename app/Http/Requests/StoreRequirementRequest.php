<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequirementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'requirement_name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'is_required' => ['boolean'],
        ];
    }
}
