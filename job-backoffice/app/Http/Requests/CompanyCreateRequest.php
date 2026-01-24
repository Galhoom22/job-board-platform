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
            'name' => 'required|string|max:255|unique:companies,name',
            'address' => 'required|string|max:500',
            'industry' => 'required|string|max:100',
            'website' => 'nullable|url|max:255',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|unique:users,email',
            'owner_password' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Company name is required',
            'name.unique' => 'Company name already exists',
            'name.max' => 'Company name must be less than 255 characters',
            'name.string' => 'Company name must be a string',
            'address.required' => 'Address is required',
            'address.string' => 'Address must be a string',
            'address.max' => 'Address must be less than 500 characters',
            'industry.required' => 'Industry is required',
            'industry.string' => 'Industry must be a string',
            'industry.max' => 'Industry must be less than 100 characters',
            'website.url' => 'Website must be a valid URL',
            'website.max' => 'Website must be less than 255 characters',
            'owner_name.required' => 'Owner name is required',
            'owner_name.max' => 'Owner name must be less than 255 characters',
            'owner_email.required' => 'Owner email is required',
            'owner_email.email' => 'Owner email must be a valid email',
            'owner_email.unique' => 'Owner email already exists',
            'owner_password.required' => 'Owner password is required',
            'owner_password.min' => 'Owner password must be at least 8 characters',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Company Name',
            'address' => 'Address',
            'industry' => 'Industry',
            'website' => 'Website',
            'owner_name' => 'Owner Name',
            'owner_email' => 'Owner Email',
            'owner_password' => 'Owner Password',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (strtolower(trim($this->name)) === 'admin') {
                $validator->errors()->add('name', 'Company name cannot be Admin');
            }
        });
    }
}