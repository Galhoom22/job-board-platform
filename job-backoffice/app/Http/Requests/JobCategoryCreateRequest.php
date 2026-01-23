<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobCategoryCreateRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:job_categories,name',
            'description' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required',
            'name.unique' => 'Category name already exists',
            'name.max' => 'Category name must be less than 255 characters',
            'name.string' => 'Category name must be a string',
            'description.string' => 'Description must be a string',
            'description.max' => 'Description must be less than 500 characters',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Category Name',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->name == 'Admin') {
                $validator->errors()->add('name', 'Category name cannot be Admin');
            }
        });
    }
}