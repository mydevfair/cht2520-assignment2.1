<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppointmentRequest extends FormRequest
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
            'doctor_id' => [
                'required',
                'exists:doctors,id'
            ],
            'appointment_date' => [
                'required',
                'date',
                'after_or_equal:today'
            ],
            'appointment_time' => [
                'required',
                'date_format:H:i'
            ],
            'reason' => [
                'required',
                'string',
                'max:255'
            ],
            'status' => [
                'required',
                Rule::in(['scheduled', 'completed', 'cancelled'])
            ],
            'notes' => [
                'nullable',
                'string',
                'max:1000'
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

            'doctor_id.required' => 'Please select a doctor.',
            'doctor_id.exists' => 'The selected doctor does not exist.',

            'appointment_date.required' => 'The appointment date is required.',
            'appointment_date.date' => 'Please enter a valid date.',
            'appointment_date.after_or_equal' => 'The appointment date cannot be in the past.',

            'appointment_time.required' => 'The appointment time is required.',
            'appointment_time.date_format' => 'Please enter time in HH:MM format (e.g., 14:30).',

            'reason.required' => 'Please provide a reason for the appointment.',
            'reason.max' => 'The reason cannot exceed 255 characters.',

            'status.required' => 'Please select an appointment status.',
            'status.in' => 'Invalid appointment status selected.',

            'notes.max' => 'Notes cannot exceed 1000 characters.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'patient_id' => 'patient',
            'doctor_id' => 'doctor',
            'appointment_date' => 'appointment date',
            'appointment_time' => 'appointment time',
            'reason' => 'reason',
            'status' => 'status',
            'notes' => 'notes',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $this->merge([
                'appointment_date' => $this->appointment_date,
            ]);
        }
    }
}
