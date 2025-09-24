<?php

namespace App\DTOs;

class UpdateInvoiceDTO
{
    public function __construct(
        public readonly ?string $customer_name = null,
        public readonly ?string $customer_email = null,
        public readonly ?float $amount = null,
        public readonly ?string $status = null,
        public readonly ?string $due_date = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            customer_name: $data['customer_name'] ?? null,
            customer_email: $data['customer_email'] ?? null,
            amount: $data['amount'] ?? null,
            status: $data['status'] ?? null,
            due_date: $data['due_date'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'amount' => $this->amount,
            'status' => $this->status,
            'due_date' => $this->due_date,
        ], fn ($value) => !is_null($value));
    }
}
