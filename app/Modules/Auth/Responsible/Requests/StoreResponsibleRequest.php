<?php

namespace App\Modules\Auth\Responsible\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreResponsibleRequest extends FormRequest
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
            'password' => ['required'],
            'phone' => ['required', 'unique:responsibles'],
            'responsible_types' => ['required'],
            'image' => [],
            'email' => ['nullable', 'unique:responsibles'],
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone.unique' => 'Number already exists',
            'email.unique' => 'Email already exists'
        ];
    }
}
