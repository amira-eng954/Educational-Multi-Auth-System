<?php


namespace App\Http\Requests\Teacher;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

use Illuminate\Foundation\Http\FormRequest;


class CourseRequest extends FormRequest
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
            //
            'title'=>"required|max:255",
            'desc'=>'nullable|string',
            'price'=>"integer|required",
            'image'=>"nullable|image|mimes:png,jpg"

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
