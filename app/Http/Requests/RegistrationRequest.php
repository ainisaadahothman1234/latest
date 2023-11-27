<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:users,name',
            'staff_id' => 'required|unique:users,staff_id',
            'category' => 'required',
            'service' => 'required',
            'position' => 'required',
            'no' => 'required|string|unique:users,no',
            'password' => 'required',
        ];
    }

}
