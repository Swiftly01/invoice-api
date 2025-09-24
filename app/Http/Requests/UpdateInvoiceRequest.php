<?php

namespace App\Http\Requests;

use App\Enums\InvoiceStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'customer_name'  => ['sometimes', 'string', 'max:255'],
            'customer_email' => ['sometimes', 'email', 'max:255'],
            'amount'         => ['sometimes', 'numeric', 'min:0'],
            'status'         => ['sometimes', new Enum(InvoiceStatusEnum::class)],
            'due_date'       => ['sometimes', 'date'],
        ];
    }
}
