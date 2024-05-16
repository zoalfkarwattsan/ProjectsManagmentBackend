<?php

namespace App\Modules\Auth\Notification\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNotificationRequest extends FormRequest
{

  /**
   * Determine if the user is authorized to make this request.
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
      'title'=>['string','required'],
      'body'=>['string','required'],
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
