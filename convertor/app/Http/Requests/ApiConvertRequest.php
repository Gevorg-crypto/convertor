<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiConvertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'from' =>'bail|required|string',
            'to' =>'bail|required|string',
            'amount' =>'bail|required|regex:([+-]?([0-9]*[.])?[0-9]+)',
        ];
    }
}
