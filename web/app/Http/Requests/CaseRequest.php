<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseRequest extends FormRequest
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
            'client_id' => 'required',
            'subscriber_id' => 'nullable',
            'first_national_id' => 'nullable',
            'second_national_id' => 'nullable',
            'third_national_id' => 'nullable',
            'opponent_name' => 'nullable|string',
            'opponent_national_id' => 'nullable',
            'suggested_case_id' => 'required',
            'case_type' => 'required',
            'case_number' => 'nullable',
            'court_name' => 'nullable',
            'case_amount' => 'nullable',
            'benefit_date' => 'nullable',
            'jubge_name' => 'nullable',
            'case_details' => 'nullable|string',
            'client_description' => 'nullable',
            'general_information' => 'nullable|string',
            'private_information' => 'nullable|string',
            'file_number' => 'nullable',
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'client_id.required' => 'يجب اختيار العميل',
            'client_id.exists' => 'العميل غير موجود في النظام',

            'first_national_id.digits' => 'الرقم القومي يجب أن يتكون من 14 رقم',
            'second_national_id.digits' => 'الرقم القومي يجب أن يتكون من 14 رقم',
            'third_national_id.digits' => 'الرقم القومي يجب أن يتكون من 14 رقم',

            'opponent_national_id.digits' => 'الرقم القومي يجب أن يتكون من 14 رقم',

            'suggested_case_id.required' => 'يجب اختيار القضية المقترحة',
            'suggested_case_id.exists' => 'القضية المقترحة غير صحيحة',
            'requested_case_id.exists' => 'القضية المطلوبة غير صحيحة',

            'case_type.required' => 'يجب اختيار نوع القضية',
            'case_type.in' => 'نوع القضية يجب أن يكون حقوقي أو شرعي أو جزائي',

            'case_amount.numeric' => 'قيمة القضية يجب أن تكون رقمية',
            'benefit_date.date' => 'تاريخ الاستحقاق يجب أن يكون تاريخ صحيح',
        ];
    }
}
