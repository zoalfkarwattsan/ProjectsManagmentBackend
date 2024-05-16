<?php

namespace App\Modules\Box\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBoxRequest extends FormRequest
{

  /**
   * Determine if the box is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'election_id' => ['required'],
      'name' => ['required'],
      'room_number' => ['required'],
      'sheet_id' => ['required'],
      'electors.*.civil_registration_from' => ['required'],
      'electors.*.civil_registration_to' => ['required'],
      'electors.*.religion' => ['required', 'min:1'],
      'electors.*.gender' => ['required', 'min:1'],
    ];
  }

  /**
   * Get the validation messages that apply to the request.
   *
   * @return array
   */
//    public function messages() {
//        return ['name.required' => 'Name Field is Required', 'email.required' => 'Email Field is Required', 'password.required' => 'Password Field is Required'];
//    }
}
