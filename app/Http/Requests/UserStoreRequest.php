<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'exists:roles,id'],
            'password' => ['required', 'string', 'min:8'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => __('User name is required'),
            'email.required' => __('User email is required'),
            'email.email' => __('User email must be a valid email address'),
            'email.unique' => __('User email must be unique'),
            'role.required' => __('User role is required'),
            'password.required' => __('User password is required'),
            'password.min' => __('User password must be at least 8 characters'),
        ];
    }
}
