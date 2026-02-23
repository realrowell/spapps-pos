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
        Schema::create('sale_payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_ref')->unique();
            $table->unsignedBigInteger('sale_id')->index();
            $table->string('mop');
            $table->unsignedBigInteger('mop_id')->nullable()->index();
            $table->decimal('amount', 12, 2);
            $table->string('status');
            $table->string('reference_no')->nullable();
            $table->string('provider')->nullable();
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
        Schema::dropIfExists('sale_payments');
    }
};
