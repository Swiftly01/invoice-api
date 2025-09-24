<?php

use App\Enums\InvoiceStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
             $table->id();
            $table->string('invoice_number')->unique();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->decimal('amount', 12, 2);
            $table->enum('status', InvoiceStatusEnum::values())->default(InvoiceStatusEnum::ISSUED->value)->index();
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
