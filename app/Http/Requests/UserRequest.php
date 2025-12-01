<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
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
     */
    public function rules(): array
    {
        $userId = $this->route('user') ? $this->route('user')->id : null;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\-\'\.]+$/'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                $userId ? 'unique:users,email,' . $userId : 'unique:users,email'
            ],
            'password' => [
                $userId ? 'nullable' : 'required', // Required on create, optional on update
                'confirmed',
                Password::defaults()
            ],
            'role' => [
                'required',
                'exists:roles,name'
            ]
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The user name is required.',
            'name.string' => 'The user name must be text.',
            'name.max' => 'The user name cannot exceed 255 characters.',
            'name.regex' => 'The user name may only contain letters, spaces, hyphens, apostrophes, and periods.',

            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'email.max' => 'The email address cannot exceed 255 characters.',

            'password.required' => 'The password is required.',
            'password.confirmed' => 'The password confirmation does not match.',

            'role.required' => 'Please select a role for this user.',
            'role.exists' => 'The selected role is invalid.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'user name',
            'email' => 'email address',
            'password' => 'password',
            'role' => 'role',
        ];
    }
}
