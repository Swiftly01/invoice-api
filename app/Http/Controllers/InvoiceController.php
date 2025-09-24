<?php

namespace App\Http\Controllers;

use App\DTOs\CreateInvoiceDTO;
use App\DTOs\UpdateInvoiceDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    public function __construct(protected InvoiceService $invoiceService) {}

    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);
        $paginatedData = $this->invoiceService->listInvoices($perPage);

    
        return $this->successResponse(
            status: true,
            message: 'Invoices successfully fetched',
            data: InvoiceResource::collection($paginatedData),
          
        );
    }

    public function store(StoreInvoiceRequest $request)
    {   
    
        try {
            $dto = CreateInvoiceDTO::fromArray($request->validated());

            $invoice = $this->invoiceService->createInvoice($dto);

            return $this->successResponse(
                status: true,
                message: 'Invoice successfully created',
                data: new InvoiceResource($invoice),
                statusCode: 201
            );

        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage(), 'message' => 'Invoice creation failed']);
            return $this->errorResponse(
                status: false,
                message: 'Invoice creation failed',
                statusCode: 400
            );
        }
    }

    public function show(int $id)
    {
        $invoice = $this->invoiceService->getInvoice($id);
        if (!$invoice) {
            return $this->errorResponse(
                status: false,
                message: 'Invoice not found',
                statusCode: 404
            );
        }

        return $this->successResponse(
            status: true,
            message: 'Invoice successfully fetched',
            data: new InvoiceResource($invoice)
        );
    }

    public function update(UpdateInvoiceRequest $request, int $id)
    {
        $dto = UpdateInvoiceDTO::fromArray($request->validated());
        $invoice = $this->invoiceService->updateInvoice($id, $dto);

        if (!$invoice) {
            return $this->errorResponse(
                status: false,
                message: 'Invoice not found',
                statusCode: 404
            );
        }

        return $this->successResponse(
            status: true,
            message: 'Invoice successfully updated',
            data: new InvoiceResource($invoice)
        );
    }

    public function destroy(int $id)
    {
        $deleted = $this->invoiceService->deleteInvoice($id);

        if (!$deleted) {
            return $this->errorResponse(
                status: false,
                message: 'Invoice not found',
                statusCode: 404
            );
        }

        return $this->successResponse(
            status: true,
            message: 'Invoice successfully deleted'
        );
    }
}
