<?php

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
        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales', 'id')->onDelete('restrict');
            $table->string('public_id')->unique();
            $table->string('invoice_no')->unique();
            $table->string('customer_name')->nullable();
            $table->string('customer_contact_no')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('customer_tin')->nullable();
            $table->dateTime('issued_at');
            $table->dateTime('printed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_invoices');
    }
};
