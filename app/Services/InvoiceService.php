<?php

namespace App\Services;

use App\Interfaces\InvoiceRepositoryInterface;
use App\Models\Invoice;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class InvoiceService
{
    /**
     * Create a new class instance.
     */


    // How many times to retry on duplicate-key errors
    public const CREATE_MAX_RETRIES = 5;

    public function __construct(protected InvoiceRepositoryInterface $invoiceRepositoryInterface) {}

    /**
     * Create an invoice with safe retry to avoid race condition on unique invoice_number.
     *
     * $data must include customer_name and amount, and optional due_date, customer_email, status.
     */
    public function createInvoice(array $data): Invoice
    {
        $attempt = 0;
        beginning:
        $attempt++;

        // generate invoice number (customize as needed). Could be sequential or UUID.
        // If you need strictly incremental numbers, use DB sequence table with FOR UPDATE (more below).
        $data['invoice_number'] = $this->generateInvoiceNumber();

        // wrap in DB transaction for safety (atomic)
        try {
            return DB::transaction(function () use ($data) {
                return $this->invoiceRepositoryInterface->create($data);
            });
        } catch (QueryException $ex) {
            // SQLSTATE 23000 is constraint violation (MySQL duplicate key)
            $sqlState = $ex->getCode();
            if (($sqlState === '23000' || strpos($ex->getMessage(), 'Duplicate') !== false) && $attempt < self::CREATE_MAX_RETRIES) {
                // small backoff to reduce collision
                usleep(100 * 1000); // 100ms
                goto beginning;
            }

            // rethrow if not handled
            throw $ex;
        } catch (Throwable $t) {
            throw $t;
        }
    }

    protected function generateInvoiceNumber(): string
    {
        // Example: INV-YYYYMMDD-<random 6>
        return 'INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
    }

    public function getInvoice(int $id): ?Invoice
    {
        return $this->invoiceRepositoryInterface->find($id);
    }

    public function listInvoices(int $perPage = 15)
    {
        return $this->invoiceRepositoryInterface->paginate($perPage);
    }
}
