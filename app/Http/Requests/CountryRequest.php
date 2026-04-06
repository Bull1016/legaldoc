<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'nameCountry'      => ['required', 'string', 'max:255'],
    ];
  }

  public function attributes(): array
  {
    return [
      'nameCountry'   => __('Area Name'),
    ];
  }

  public function messages(): array
  {
    return [
      'nameCountry.required' => __('Area name is required'),
    ];
  }
}
