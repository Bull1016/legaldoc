<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnerStoreRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'name'      => ['required', 'string', 'max:255'],
      'pic'      => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
      'location'      => ['required', 'string', 'max:255'],
    ];
  }

  public function attributes(): array
  {
    return [
      'name'   => __('Partner Name'),
      'pic'   => __('Partner Pic'),
      'location'   => __('Partner Location'),
    ];
  }

  public function messages(): array
  {
    return [
      'name.required' => __('Partner name is required'),
      'pic.required' => __('Partner pic is required'),
      'location.required' => __('Partner location is required'),
    ];
  }
}
