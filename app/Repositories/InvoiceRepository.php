<?php

namespace App\Repositories;

use App\Interfaces\InvoiceRepositoryInterface;
use App\Models\Invoice;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create(array $data): Invoice
    {
        return Invoice::create($data);
    }

    public function find(int $id): ?Invoice
    {
        return Invoice::find($id);
    }

    public function findByInvoiceNumber(string $number): ?Invoice
    {
        return Invoice::where('invoice_number', $number)->first();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Invoice::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function update(int $id, array $dto): bool
    {
        return Invoice::find($id)->update($dto);
    }

    public function destroy(int $id): bool
    {
        return Invoice::destroy($id);
    }
}
