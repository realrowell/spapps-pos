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
        Schema::create('purchase_payments', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_ref')->unique();
            $table->unsignedBigInteger('purchase_id')->index();
            $table->unsignedBigInteger('payment_provider_id')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('external_transaction_id')->nullable();
            $table->string('reference_no')->nullable();
            $table->dateTime('paid_at')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_payments');
    }
};
