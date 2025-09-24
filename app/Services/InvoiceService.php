<?php

namespace App\Services;

use App\DTOs\CreateInvoiceDTO;
use App\DTOs\UpdateInvoiceDTO;
use App\Interfaces\InvoiceRepositoryInterface;
use App\Models\Invoice;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class InvoiceService
{


    public function __construct(protected InvoiceRepositoryInterface $invoiceRepositoryInterface) {}

    public function createInvoice(CreateInvoiceDTO $dto): Invoice
    {
        return DB::transaction(function () use ($dto) {
            return $this->invoiceRepositoryInterface->create([
                'invoice_number' => $this->generateInvoiceNumber(),
                ...$dto->toArray()
            ]);
        });
    }

    public function updateInvoice(int $id, UpdateInvoiceDTO $dto): ?Invoice
    {
        $invoice = $this->invoiceRepositoryInterface->find($id);
        if (!$invoice) {
            return null;
        }
        $this->invoiceRepositoryInterface->update($id, $dto->toArray());
        return $this->invoiceRepositoryInterface->find($id);
    }

    public function deleteInvoice(int $id): bool
    {
        return $this->invoiceRepositoryInterface->destroy($id);
    }

    public function getInvoice(int $id): ?Invoice
    {
        return $this->invoiceRepositoryInterface->find($id);
    }

    public function listInvoices(int $perPage = 15)
    {
        return $this->invoiceRepositoryInterface->paginate($perPage);
    }

    protected function generateInvoiceNumber(): string
    {
        return 'INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
    }
}
