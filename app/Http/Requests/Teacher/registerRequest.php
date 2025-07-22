<?php

namespace App\Http\Requests\Teacher;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

use Illuminate\Foundation\Http\FormRequest;

class registerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //

            'name'=>"required|string|max:255",
            'email'=>"required|email|unique:teachers,email",
            'password'=>"required|min:3|",
            'phone'=>'required|string',
            'image'=>'nullable',
            'age'=>'required|min:12'
        ];
    }

    protected function failedValidation(Validator $validator)
{
    throw new HttpResponseException(
        response()->json([
            'status' => false,
            'message' => $validator->errors()->first()
        ], 422)
    );
}

}
        
