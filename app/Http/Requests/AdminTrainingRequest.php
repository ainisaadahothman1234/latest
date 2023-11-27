<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminTrainingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'code' => 'required',
            'type' => 'required',
            'category' => 'required',
            'speaker' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'time_start' => 'required',
            'time_end' => 'required',
            'duration' => 'required | numeric',
            'location' => 'required',
            'quantity' => 'required | integer',
            'price' => 'required | numeric',
            'detail' => 'required|string',
            'remark' => 'required|string',
        ];
    }
}
