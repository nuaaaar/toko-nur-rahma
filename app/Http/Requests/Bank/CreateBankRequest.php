<?php

namespace App\Http\Requests\Bank;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateBankRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->can('banks.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'account' => 'required|unique:banks,account,NULL,id,deleted_at,NULL',
            'account_name' => 'required'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama bank',
            'account' => 'no. rekening',
            'account_name' => 'atas nama'
        ];
    }
}
