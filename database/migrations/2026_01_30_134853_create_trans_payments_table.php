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
            $table->id();
            $table->string('public_id')->unique();
            $table->unsignedBigInteger('trans_id')->index();
            $table->string('payment_method');
            $table->unsignedBigInteger('mop_id')->nullable()->index();
            $table->decimal('amount', 15, 2);
            $table->string('status');
            $table->string('reference_number')->nullable();
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
        Schema::dropIfExists('trans_payments');
    }
};
