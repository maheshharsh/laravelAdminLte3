<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required', 'string', 'max:191',
            'email'=>'required','email','unique:users,email',
            'password' => isset($this->user) ? 'nullable' : 'required' , 'string', 'min:8' , 'max:191',
            'c_password' => 'same:password',
            'mobileno' => 'required', 'regex:/^([+]?)([0-9]*)$/', 'max:20',
            'gender'=>'required',
            'status' => 'required',
            'role' => 'required', 'exists:roles,id',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email address field is required.',
            'password.required' => 'The password field is required.',
            'c_password.required' => 'The confirm password field is required.',
            'c_password.same' => 'The confirm password field must match password.',
            'mobileno.required' => 'The mobile number field is required.',
            'gender.required' => 'The gender field is required.',
            'status.required' => 'The status field is required.',
            'role.required' => 'The role field is required.',
        ];
    }
}
