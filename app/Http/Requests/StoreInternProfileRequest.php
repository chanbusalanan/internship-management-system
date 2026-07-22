<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInternProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_number' => ['required', 'string', 'max:30'],
            'school' => ['required', 'string', 'max:150'],
            'course' => ['required', 'string', 'max:100'],
            'year_level' => ['required', 'integer', 'min:1', 'max:6'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'emergency_contact' => ['nullable', 'string', 'max:100'],
        ];
    }
}
