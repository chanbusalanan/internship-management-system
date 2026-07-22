<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'score' => ['required', 'numeric', 'min:0', 'max:5'],
            'remarks' => ['nullable', 'string'],
            'evaluation_date' => ['required', 'date', 'before_or_equal:today'],
        ];
    }
}
