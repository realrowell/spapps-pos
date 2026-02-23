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
            $table->string('mop');
            $table->unsignedBigInteger('mop_id')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('reference_no')->nullable();
            $table->dateTime('paid_at');
            $table->timestamps();
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
