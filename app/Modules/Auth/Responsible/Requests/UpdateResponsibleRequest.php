<?php

namespace App\Modules\Auth\Responsible\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateResponsibleRequest extends FormRequest
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
            'phone' => [Rule::unique('responsibles')->ignore($this->responsible->id)],
            'responsible_types' => ['required'],
            'image' => [],
            'email' => ['nullable', Rule::unique('responsibles')->ignore($this->responsible->id)],
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
