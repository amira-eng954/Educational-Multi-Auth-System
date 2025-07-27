<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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

        $id=$this->user("student_api")->id;
        return [
            //
            'name'=>"required|string|max:255",
            'email'=>[
                'required',
                'email',
                Rule::unique("students",'email')->ignore($id)
            ],
            'image'=>"nullable|image|mimes:png,jpg",
            'phone'=>"required|string"
        ];
    }
}
