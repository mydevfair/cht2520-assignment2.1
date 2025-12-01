<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50|regex:/^[a-zA-Z\s\-\'\.]+$/',
            'specialty' => 'required|string|max:50|regex:/^[a-zA-Z\s\-\']+$/',
            'phone' => [
                'required',
                'regex:/^(?:(?:\+44\s?|0)(?:\d\s?){10})$/',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                $this->route('doctor')
                    ? 'unique:doctors,email,' . $this->route('doctor')->id
                    : 'unique:doctors,email',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The doctor\'s name is required.',
            'name.max' => 'The doctor\'s name cannot exceed 50 characters.',
            'name.regex' => 'The doctor\'s name may only contain letters, spaces, hyphens, and apostrophes.',

            'specialty.required' => 'The doctor\'s specialty is required.',
            'specialty.max' => 'The specialty cannot exceed 50 characters.',
            'specialty.regex' => 'The specialty may only contain letters, spaces, hyphens, and apostrophes.',

            'phone.required' => 'The phone number is required.',
            'phone.regex' => 'Please enter a valid UK phone number.',

            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered to another doctor.',
            'email.max' => 'The email address cannot exceed 100 characters.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'doctor name',
            'specialty' => 'specialty',
            'phone' => 'phone number',
            'email' => 'email address',
        ];
    }
}
