<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganisationRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    $rules = [
      'nameOr'      => ['required', 'string', 'max:255'],
      'mailOr'      => ['required', 'email', 'max:255'],
      'numberOr'    => ['required', 'string', 'max:255'],
      'picOr'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
      'stateOr'     => ['required', 'string', 'max:255'],
      'latitude'    => ['nullable', 'numeric'],
      'longitude'   => ['nullable', 'numeric'],
      'descriptionOr' => ['required', 'string'],
      'facebook'    => ['nullable', 'string', 'max:255'],
      'whatsapp'    => ['required', 'string', 'max:255'],
    ];

    // Make picOr required only during creation (POST request)
    if ($this->isMethod('POST')) {
      $rules['picOr'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'];
    }

    return $rules;
  }

  public function attributes(): array
  {
    return [
      'nameOr'   => __('Organisation name'),
      'mailOr'   => __('Organisation email'),
      'numberOr' => __('Organisation phone'),
      'picOr'    => __('Organisation pic'),
      'stateOr'  => __('Organisation state'),
      'descriptionOr' => __('Organisation description'),
      'facebook' => __('Organisation facebook'),
      'whatsapp' => __('Organisation whatsapp'),
    ];
  }

  public function messages(): array
  {
    return [
      'nameOr.required' => __('Organisation name is required'),
      'mailOr.required' => __('Organisation email is required'),
      'numberOr.required' => __('Organisation phone is required'),
      'stateOr.required' => __('Organisation state is required'),
      'descriptionOr.required' => __('Organisation description is required'),
      'whatsapp.required' => __('Organisation whatsapp is required'),
    ];
  }
}
