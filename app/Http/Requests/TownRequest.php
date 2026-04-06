<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TownRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'nameTown'      => ['required', 'string', 'max:255'],
    ];
  }

  public function attributes(): array
  {
    return [
      'nameTown'   => __('Area Name'),
    ];
  }

  public function messages(): array
  {
    return [
      'nameTown.required' => __('Region name is required'),
    ];
  }
}
