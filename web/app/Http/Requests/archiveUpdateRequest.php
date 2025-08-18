<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class archiveUpdateRequest extends FormRequest
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
            'sub_menu_id' => 'nullable',
            'notes' => 'nullable',
            'user_id' => 'nullable',
            'file' => 'nullable',
            'main_menu_id' => 'nullable',
            'time' => 'nullable',
            'another_names' => 'nullable',
            'client_id' => 'nullable',

        ];
    }
}
