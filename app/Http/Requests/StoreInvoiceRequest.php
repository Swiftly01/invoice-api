<?php

namespace App\Http\Requests;

use App\Enums\InvoiceStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreInvoiceRequest extends FormRequest
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
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'amount' => 'required|numeric|min:0.01',
            'due_date' => 'nullable|date',
            'status' => ['nullable',new Enum(InvoiceStatusEnum::class)],
        ];
    }
}
