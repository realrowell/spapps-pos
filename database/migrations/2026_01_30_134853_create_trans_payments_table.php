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
        Schema::create('trans_payments', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('trans_id');
            $table->string('payment_method');
            $table->string('mop_id')->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('status');
            $table->string('reference_number')->nullable();
            $table->string('provider_')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_payments');
    }
};
