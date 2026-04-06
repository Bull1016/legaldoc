<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PositionRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'name'      => ['required', 'string', 'max:255'],
    ];
  }

  public function attributes(): array
  {
    return [
      'name'   => __('Position Name'),
    ];
  }

  public function messages(): array
  {
    return [
      'name.required' => __('Position name is required'),
    ];
  }
}
