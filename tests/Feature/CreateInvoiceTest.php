<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateInvoiceTest extends TestCase
{
     use RefreshDatabase;

    public function test_can_create_invoice()
    {
        $payload = [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'amount' => 150.75,
            'due_date' => now()->addDays(7)->toDateString()
        ];

        $response = $this->postJson('/api/invoices', $payload);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data' => [
                          'id', 'attributes' => ['invoice_number','customer_name','amount','status','due_date','created_at']
                     ]
                 ]);

        $this->assertDatabaseHas('invoices', [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'amount' => 150.75,
        ]);
    }
}
