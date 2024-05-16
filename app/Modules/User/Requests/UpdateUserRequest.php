<?php

namespace App\Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'fname' => ['required'],
            'mname' => ['required'],
            'lname' => ['required'],
            'mother_name' => ['required'],
            'gender' => ['required'],
            'civil_registration' => ['required'],
            'personal_religion' => ['required'],
            'record_religion' => ['required'],
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
