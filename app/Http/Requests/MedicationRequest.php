<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicationRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-Z0-9\s\-\'\.]+$/'
            ],
            'type' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-Z\s\-]+$/'
            ],
            'manufacturer' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[a-zA-Z0-9\s\-\'\.&]+$/'
            ],
            'description' => [
                'nullable',
                'string',
                'max:500'
            ]
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The medication name is required.',
            'name.max' => 'The medication name cannot exceed 100 characters.',
            'name.regex' => 'The medication name may only contain letters, numbers, spaces, hyphens, apostrophes, and periods.',

            'type.required' => 'The medication type is required.',
            'type.max' => 'The type cannot exceed 50 characters.',
            'type.regex' => 'The type may only contain letters, spaces, and hyphens.',

            'manufacturer.max' => 'The manufacturer name cannot exceed 100 characters.',
            'manufacturer.regex' => 'The manufacturer name may only contain letters, numbers, spaces, hyphens, apostrophes, periods, and ampersands.',

            'description.max' => 'The description cannot exceed 500 characters.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'medication name',
            'type' => 'medication type',
            'manufacturer' => 'manufacturer',
            'description' => 'description',
        ];
    }
}
