<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required_if:*.'.!\Auth::check().', Email is required', 'string', 'email', 'max:255'],
            'reaching_out_us' => ['required'],
            'primary_platform' => ['required'],
            // 'anything_else' => ['required'],
        ];    
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => $validator->errors()->all(),
            'erro' => '422'
        ], 200));
    }
}
