<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class archiveRequest extends FormRequest
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
            'sub_menu_id' => 'required',
            'notes' => 'nullable',
            'user_id' => 'required',
            'file' => 'required',
            'main_menu_id' => 'required',
            'time' => 'required',
            'another_names' => 'nullable',
            'client_id' => 'required',
        ];
    }
}