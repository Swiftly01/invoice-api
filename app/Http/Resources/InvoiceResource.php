<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    // public function toArray(Request $request): array
    // {
    //     return parent::toArray($request);
    // }
    protected string $type;

    public function __construct($resource, string $type)
    {
        parent::__construct($resource);
        $this->type = $type;
    }

    public function toArray($request): array
    {
        // JSON:API resource object
        return [
            'type' => $this->type,
            'id' => (string) $this->id,
            'attributes' => [
                'invoice_number' => $this->invoice_number,
                'customer_name' => $this->customer_name,
                'customer_email' => $this->customer_email,
                'amount' => (string) $this->amount,
                'status' => $this->status,
                'due_date' => optional($this->due_date)?->toDateString(),
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'links' => [
                'self' => url("/api/invoices/{$this->id}"),
            ],
        ];
    }
}
