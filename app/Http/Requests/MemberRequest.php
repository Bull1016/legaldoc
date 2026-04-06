<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'birth' => ['required', 'date'],
            'job' => ['required', 'string', 'max:255'],
            'sex' => ['required', 'string', 'in:male,female'],
        ];

        // Unique email & phone validation and Photo validation depending on method (store vs update)
        if ($this->isMethod('post')) {
            $rules['photo'] = ['required', 'image', 'max:2048']; // 2MB Max
            $rules['email'][] = Rule::unique('users');
            $rules['phone'][] = Rule::unique('members');
        } else {
            $rules['photo'] = ['nullable', 'image', 'max:2048']; // 2MB Max
            $member = $this->route('member');
            if ($member && $member->user_id) {
                $rules['email'][] = Rule::unique('users')->ignore($member->user_id);
            }
            if ($member && $member->phone) {
                $rules['phone'][] = Rule::unique('members')->ignore($member->phone);
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => __('Member name is required'),
            'email.required' => __('Member email is required'),
            'email.email' => __('Member email must be a valid email address'),
            'email.unique' => __('Member email already exists'),
            'phone.required' => __('Member phone is required'),
            'phone.unique' => __('Member phone already exists'),
            'photo.required' => __('Member photo is required'),
            'photo.image' => __('Member photo is invalid'),
            'birth.required' => __('Member birth is required'),
            'job.required' => __('Member job is required'),
            'sex.required' => __('Member sex is required'),
            'sex.in' => __('Member sex must be either male or female'),
        ];
    }
}
