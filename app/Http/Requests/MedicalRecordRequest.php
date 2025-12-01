<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicalRecordRequest extends FormRequest
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
            'patient_id' => [
                'required',
                'exists:patients,id'
            ],
            'file' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:10240'
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
            'patient_id.required' => 'Please select a patient.',
            'patient_id.exists' => 'The selected patient does not exist.',

            'file.required' => 'Please select a file to upload.',
            'file.file' => 'The uploaded item must be a valid file.',
            'file.mimes' => 'Only PDF, JPG, JPEG, and PNG files are allowed.',
            'file.max' => 'The file size must not exceed 10MB.',

            'description.max' => 'The description cannot exceed 500 characters.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'patient_id' => 'patient',
            'file' => 'medical record file',
            'description' => 'description',
        ];
    }
}
