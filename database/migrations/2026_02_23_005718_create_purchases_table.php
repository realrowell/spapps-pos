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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_ref')->unique();
            $table->string('trans_type')->default('purchase');
            $table->unsignedBigInteger('vendor_id');
            $table->string('status');
            $table->string('payment_status')->default('unpaid');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            $table->dateTime('expected_delivery_date')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->unsignedBigInteger('parent_purchase_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
