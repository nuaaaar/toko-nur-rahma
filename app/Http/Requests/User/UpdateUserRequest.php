<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->can('users.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'roles' => 'required|array|exists:roles,name',
            'name' => 'required',
            'email'=> "required|email|unique:users,email,{$this->user},id,deleted_at,NULL",
            'password' => 'confirmed'
        ];
    }
}
