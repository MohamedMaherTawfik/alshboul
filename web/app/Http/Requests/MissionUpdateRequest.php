<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MissionUpdateRequest extends FormRequest
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
            'client_id' => 'nullable',
            'first_lawyer' => 'nullable',
            'second_lawyer' => 'nullable',
            'deadline' => 'nullable',
            'description' => 'nullable',
            'file' => 'nullable',
        ];
    }
}