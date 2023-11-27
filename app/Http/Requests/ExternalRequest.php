<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use App\Rules\NoApplicationConflicts;
use Illuminate\Foundation\Http\FormRequest;

class externalRequest extends FormRequest
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
            'req_id' => 'required',
            'submit_date' => 'required',
            'title' => 'required',
            'type' => 'required',
            'category' => 'required',
            'speaker' => 'required',
            'location' => 'required',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'detail' => 'required|string',
            'remark' => 'required|string',
            'quantity' => 'required|integer',
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'time_start' => 'required',
            'time_end' => 'required',
            'sponsor' => 'required',
            'organizer' => 'required',
            'food' => 'required',
        ];
    }
}
