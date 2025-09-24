<?php

namespace App\DTOs;

use App\Enums\InvoiceStatusEnum;

class CreateInvoiceDTO
{
    public function __construct(
        public string $customer_name,
        public ?string $customer_email,
        public float $amount,
        public ?string $due_date,
        public ?string $status
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            customer_name: $data['customer_name'],
            customer_email: $data['customer_email'] ?? null,
            amount: $data['amount'],
            due_date: $data['due_date'] ?? null,
            status: $data['status']?? InvoiceStatusEnum::ISSUED->value,
        );
    }

    public function toArray(): array
    {
        return [
            'customer_name'  => $this->customer_name,
            'customer_email' => $this->customer_email,
            'amount'         => $this->amount,
            'due_date'       => $this->due_date,
            'status' => $this->status,
        ];
    }
}
