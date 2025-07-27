<?php

namespace App\Http\Requests\Family;

use Illuminate\Foundation\Http\FormRequest;
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

         $id=$this->user("family_api")->id;
        return [
            //

           
            'name'=>"required|max:255",
            // 'email'=>
            // [
            //     'required',
            //     'email',
            //     Rule::unique("families",'email')->ignore($id)
            // ],
            'email'=>"required|email|unique:families,email,{$id},id",
            'phone'=>"required|string",
            'image'=>"nullable|image|mimes:png,jpg",
        ];
    }
}
