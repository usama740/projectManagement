<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
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
            'name' => 'required|unique:attributes',
            'status' =>  [
                'required',
                Rule::in(['pending', 'active', 'completed']),
            ],
            'attribute_values' => 'required|array|min:1',  // Ensure it's an array
            'attribute_values.*.attribute_id' => 'required|integer|exists:attributes,id', // Ensure attribute_id exists in attributes table
            'attribute_values.*.value' => 'required|string|max:255', // Ensure value is a string and not too long
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422));
    }
}
