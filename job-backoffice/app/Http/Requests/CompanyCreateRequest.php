<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
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
            'name' => 'bail|required|string|max:255|unique:companies,name',
            'address' => 'required|string|max:500',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|string|url|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The company name is required.',
            'name.unique' => 'The company name must be unique.',
            'address.required' => 'The address is required.',
            'industry.required' => 'The industry is required.',
            'website.url' => 'The website must be a valid URL.',
            'website.max' => 'The website must not exceed 255 characters.',
            'name.max' => 'The company name must not exceed 255 characters.',
            'address.max' => 'The address must not exceed 500 characters.',
            'industry.max' => 'The industry must not exceed 255 characters.',
            'name.string' => 'The company name must be a string.',
            'address.string' => 'The address must be a string.',
            'industry.string' => 'The industry must be a string.',
            'website.string' => 'The website must be a string.',
        ];
    }
}
