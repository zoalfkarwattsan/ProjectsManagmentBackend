<?php

namespace App\Modules\Election\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateElectionRequest extends FormRequest
{

  /**
   * Determine if the election is authorized to make this request.
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
      'year' => ['required'],
      'election_date' => ['required', Rule::unique('elections')->ignore($this->election->id)],
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
