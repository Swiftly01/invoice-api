<?php

namespace App\Interfaces;

use App\Models\Invoice;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface InvoiceRepositoryInterface
{
    public function create(array $data): Invoice;

    public function find(int $id): ?Invoice;

    public function findByInvoiceNumber(string $number): ?Invoice;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function update(int $id, array $dto): bool;

    public function destroy(int $id): bool;
}
